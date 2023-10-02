<?php $this->load->view($this->public_layout."/header");?>
<!-- start: Wrapper-->
<div class="wrapper">
	<?php $this->load->view($this->public_layout."/header_layout");?>

    <div class="content-wrapper" style="min-height:86.25vh;">
        <?php echo $content;?>
    </div>
<!-- end: Wrapper-->

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>Here settings can be configured...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<? $this->load->view($this->public_layout."/footer");?>
</div>