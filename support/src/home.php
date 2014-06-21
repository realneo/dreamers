<script type="text/javascript">
$(document).ready(function() { 
	setInterval(refresh_requests,1000);
});

function refresh_requests() {
	var senddata = "ajax/refresh_requests.php";
    $.ajax({
        async:false,
        cache:false,
        url:senddata,
        type:"GET",
        dataType:"text",
        success:function (data) {
			$("#refresh_requests").html(data);
        }
    });
}
</script>
									<div class="col-md-9 col-sm-8">
											<div class="row">
												<div class="col-md-12 text-right" style="margin-right:20px;margin-bottom:20px;">
													<span id="ls_status">
														<?php
														if($web['status'] == 1) {
															?><a href="javascript:void(0);" onclick="turn_offline();"><span class="text-danger">Turn chat offline.</span></a><?php
														} else {
															?><a href="javascript:void(0);" onclick="turn_online();"><span class="text-success">Turn chat online.</span></a><?php
														}
														?>
													</span>
												</div>
											</div>
                                            <div class="table-responsive" id="refresh_requests">
                                                <!-- THE MESSAGES -->
                                                <div class="row">
													<div class="col-md-12 text-center">
														<h1 class="text-muted"><i class="fa fa-spinner"></i> Loading...</h1>
														<small>Requests are updated automatically do not have to refresh your browser.</small>
													</div>
												</div>
                                            </div><!-- /.table-responsive -->
                                        </div><!-- /.col (RIGHT) -->