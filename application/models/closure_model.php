<?php

class closure_model extends CI_Model{
	public $table;
	public $closure_table = 'closures';

	public function __construct($table_name = NULL, $closure_table = NULL){

		parent::__construct();

		$this->table = $table_name;

		if ($closure_table !== NULL) {
			$this->closure_table = $closure_table;
		}
	}



	/**
	 * Fetch children.
	 * 
	 * Example to generate nested tree:
	 * 
	 *   $data = $this->get_children(1, TRUE, FALSE, TRUE);
	 *   print_r($data);
	 * 
	 * If level/depth specified then self will be ignore.
	 * 
	 * @param  int      node id
	 * @param  boolean  include self
	 * @param  mixed    node level/depth (e.g direct children = 1) 
	 * @param  boolean  nestify the result
	 * @return mixed    array if query true
	 */
	public function get_children($node_id = 1, $self = FALSE, $level = FALSE, $nested = FALSE)
	{
				
		$this->db->select('t.*, c2.ancestor as parent, c1.lvl as level');
		$this->db->from($this->closure_table." c1");
		$this->db->join($this->table.' t','t.id = c1.descendant');
		$this->db->join($this->closure_table.' c2', 'c2.lvl IN(1) AND c2.descendant = c1.descendant','LEFT'); // ugh backticking INTs in joins @TODO
		$this->db->where('c1.ancestor',$node_id);

		if ( ! $self) {
			$this->db->where('c1.descendant <>', $node_id);
		}

		if ($level) {
			$this->db->where('c1.lvl = ', $level);
		}

		$query = $this->db->get();

		if ( ! $query->num_rows()) {
			return FALSE;
		}

		$result = $query->result_array();

		if ($nested AND ! $level) {

			$trees = array();
			$root = null;

			foreach ($result as $row) {
				$trees[$row['id']] = $row;
			}

			foreach ($trees as $key => $row) {
				if( ! $root) {
					$root = $row['parent'];
				}

				$trees[$row['parent']]['children'][$key] =& $trees[$key];
			}

			$result = $trees[$root];

			if ( ! $self) {
				return $result['children'];
			}

			return isset($result['id']) ? $result : array_shift($result['children']);
		}

		return $result;

		
	}

	/**
	 * Add a node (as last child).
	 * 
	 * @param  int    node id
	 * @param  int    target id
	 * @return boolean
	 */
	public function add($node_id, $target_id = 0) {

		$sql = 'SELECT ancestor, '.$node_id.', lvl+1
				FROM '.$this->closure_table.'
				WHERE descendant = '.$target_id.'
				UNION 
				SELECT '.$node_id.','.$node_id.',0';

		$query = 'INSERT INTO '.$this->closure_table.' (ancestor, descendant,lvl) ('.$sql.')';

		$result = $this->db->query($query);

		return $result;

	}

	/**
	 * Check if current node has children.
	 * 
	 * @param   int       node id
	 * @return  boolean
	 */
	public function has_children($node_id)
	{
		$this->db->select('descendant')
			->from($this->closure_table)
			->where('ancestor', $node_id);

		$descendants = $this->db->get()->result_array();

		foreach ($descendants as $k => $v) {
			$descendants[$k] = $v['descendant'];
		}
		

		$query = $this->db->select('COUNT(*) as total')
						->from($this->closure_table)
						->where_in('ancestor', implode(',', $descendants))
						->where('descendant <>',$node_id)
						->get();

		return (bool) $query->row()->total;

		
	}

	/**
	 * Get parent(s) of current node.
	 * 
	 * @param  int    current node id
	 * @param  mixed  level up (e.g direct parent = 1)
	 * @return mixed  array if succeed
	 */
	public function get_parent($node_id, $level = NULL)
	{
		
		$this->db->select('t.*')
				->from($this->table.' t')
				->join($this->closure_table.' c','t.id = c.ancestor')
				->where('c.descendant',$node_id)
				->where('c.ancestor <>',$node_id);

		if ($level) {
			$this->db->where('c.lvl', $level);
		}

		$this->db->order_by('t.id');

		$query = $this->db->get();

		if ($query->num_rows()) {
			if ($level) {
				return $query->row();
			}

			return $query->result();
		}

		return FALSE;
	}

	/**
	 * TODO: optional recursion
	 * 
	 * Delete node.
	 * 
	 * @param  int      node id
	 * @param  boolean  if TRUE, it will also delete from reference table
	 * @return mixed
	 */
	public function delete($node_id, $delete_reference = TRUE)
	{
		

		$operand = 'select descendant as id from '.$this->closure_table.' where ancestor = '.$node_id;

		$query = 'select id, descendant from '.$this->closure_table.' where descendant IN ('.$operand.')';


		$result_start = $this->db->query($query);

		
		if ( $result_start->num_rows() > 0 ) {

			$descendants = pluck($result_start->result(), 'id');
			$result_delete = $this->db->where_in('id', implode(',', $descendants))->delete($this->closure_table);
			
			if ($delete_reference) {
				$descendants = pluck($result_start->result(), 'descendant');
				$delete_refs = $this->db->where_in('id', implode(',', $descendants))->delete($this->table);
			}

			return $result_delete;
		}

		return FALSE;
	}

	/**
	 * Move node with its children to another node.
	 * 
	 * @link  http://www.mysqlperformanceblog.com/2011/02/14/moving-subtrees-in-closure-table/
	 * 
	 * @param  int  node to be moved
	 * @param  int  target node
	 * @return void
	 */
	public function move($node_id, $target_id)
	{
		// MySQL’s multi-table DELETE
		$query1 = 'DELETE a FROM '.$this->closure_table.' AS a ';
		$query1 .= 'JOIN '.$this->closure_table.' AS d ON a.descendant = d.descendant ';
		$query1 .= 'LEFT JOIN '.$this->closure_table.' AS x ';
		$query1 .= 'ON x.ancestor = d.ancestor AND x.descendant = a.ancestor ';
		$query1 .= 'WHERE d.ancestor = '.$node_id.'  AND x.ancestor IS NULL';

		$res1 = $this->db->query($query1);

		$query2 = 'INSERT INTO '.$this->closure_table.' (ancestor, descendant, lvl) ';
		$query2 .= 'SELECT a.ancestor, b.descendant, a.lvl+b.lvl+1 ';
		$query2 .= 'FROM '.$this->closure_table.' AS a JOIN '.$this->closure_table.' AS b ';
		$query2 .= 'WHERE b.ancestor = '.$node_id.' AND a.descendant = '.$target_id;

		$res2 = $this->db->query($query2);

		return $res1 AND $res2;
	}

	/**
	 * Get (all) root nodes.
	 */
	public function get_root() {
		$this->db->select('r.descendant');
		$this->db->from($this->closure_table." r");
		$this->db->join($this->closure_table." p","r.descendant = p.descendant AND p.ancestor <> p.descendant","LEFT");
		$this->db->where('p.descendant IS NULL',NULL);

		$result = $this->db->get();

		if ($result) {
			return pluck($result->result(),'descendant');
		} else {
			return false;
		}

		
	}
	
	
	
}
