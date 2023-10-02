<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<h2>List API</h2>
<table border="1" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <td><strong>URL</strong></td>
      <td><strong>Method</strong></td>
      <td><strong>Parameters</strong></td>
      <td><strong>Description</strong></td>
    </tr>
  	<tr>
      <td><?=$this->base_url?>data_service/pasien/all/</td>
      <td>GET</td>
      <td></td>
      <td>Fetch Data Pasien in Table Pasien</td>
    </tr>
    <tr>
      <td><?=$this->base_url?>data_service/pasien/read/:idx</td>
      <td>GET</td>
      <td>idx pasien</td>
      <td>Fetch Data Pasien Detail</td>
    </tr>
  </tbody>
</table>

<h2>Common Parameter</h2>
<table border="1">
	<tr>
    	<td>parameter</td>
    	<td>Description</td>
        <td>Example</td>
    </tr>
	<tr>
    	<td>q</td>
        <td>Searching string in all text field</td>
        <td>
			<?=$this->base_url?>data_service/pasien/all?q=[search_text]
        </td>
    </tr>
    <tr>
    	<td>limit,offset</td>
        <td>Limit and offset data</td>
        <td>
			<?=$this->base_url?>data_service/pasien/all?limit=[limit_param]&offset=[offset_param]
        </td>
    </tr>
    <tr>
    	<td>sort</td>
        <td>order by field name and type of sorting</td>
        <td>?sort=nama desc</td>
    </tr>
    
    <tr>
    	<td>gt,gte</td>
        <td>greater than,greater than equal</td>
        <td>?[num_field_name]_gte=[number]<br>
        	?idx_gte=3 (mean as: idx >= 3)
        </td>
    </tr>
    <tr>
    	<td>lt,lte</td>
        <td>lower than, lower than equal</td>
        <td>same as above</td>
    </tr>
   <tr>
    	<td>format</td>
        <td>format=json|html|xml</td>
        <td>?format=[json or html or xml]
        </td>
    </tr>
    
    
</table>
</body>
</html>
