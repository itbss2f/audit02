
<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('entry/newdata')?>">Home</a></li>
    <li class="active">Transaction</li>
    <li><a href="<?php echo site_url('entry/actionplan')?>">Action Plan Records</li>
</div>
<!-- begin row -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" id="refresh" title="Reload" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-repeat"></i></a>
                </div>
                <h4 class="panel-title">Edit Action Plan Form - <?php echo $this->session->userdata('sess_company_name');?></h4>
            </div>
            <div class="panel-body">
                <form action="<?php echo site_url('entry/updateaction/'.$data['id'].'/'.$data['code'].'/'.$data['ap_status']) ?>" method="post" data-parsley-validate="true" name="form-wizard" name="formsave" id="formsave">
                    <div id="wizard">
                        <ol style="padding: 0px;">
                             <li>
                                <label> Action Plan </label>    <!--Step 2 -->
                            </li>
                        </ol>
                        <!--begin wizard step-2-->
                        <div class="wizard-step-1">
                            <fieldset>
                                <div class="row-form-booking pull-right">
                                    <button type="button" class="btn btn-success btn-sm" id="saveaction" name="saveaction" value="saveaction">Update</button>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Action Plan</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <Label style="font-size: 12px;font-weight: bold;">Date Entered</label>
                                            <input class="btn btn-success btn-xs" type="text" name="entered_date" id="entered_date" value="<?php echo date('F j\, Y \ l', strtotime($data['ap_entered_date'])); ?>"/>
                                        </div>
                                    </div>
									<div class="col-md-7">
                                    </div>
									<div class="col-md-2">
                                        <div class="form-group">
                                            <label style="font-size: 12px;font-weight: bold;">Company</label>
                                            <input class="btn btn-success btn-xs" style="width: 250px;" type="text" value="<?php echo $data['company_name'] ?>" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <!--begin row-->
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <Label>Action Code:</label>
                                            <input class="form-control" type="text" id="code" name="code" value="<?php echo $data['code'] ?>" readonly="readonly" data-parsley-required="true" required>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <Label>Bc Code:</label>
											<?php foreach ($bc_codes as $row) : ?>
                                            <?php if ($row['bcis_approved'] == 0) : ?>
                                            <a href="<?php echo site_url('entry/editbc').'/'.$row['bcid']?>" title="View" target="_blank"><?php echo $row['bc_code']?></a>
											<?php elseif ($row['bcis_approved'] == 2) : ?>
                                            <a href="<?php echo site_url('entry/viewbc').'/'.$row['bcid']?>" title="View" target="_blank"><?php echo $row['bc_code']?></a>
                                            <?php else: ?>
                                            <a href="<?php echo site_url('entry/editbcfa').'/'.$row['bcid']?>" title="View" target="_blank"><?php echo $row['bc_code']?></a>
                                            <?php endif; ?>
											<?php endforeach; ?>

                                            <input class="form-control" type="hidden" id="bc_code" name="bc_code" value="<?php echo $data['bc_code'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!--<label>ACtion Plan:</label>-->
                                            <textarea class="form-control" id="action_plan" name="action_plan" placeholder="Enter Action Plan ..." rows="8" data-parsley-required="true" required><?php echo $data['action_plan'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;margin-top: 10px;">Department Details / Employees Responsibles</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Person Responsible</label>
                                            <select class="form-control" id="ap_emp" name="ap_emp" data-parsley-required="true">
                                                <option value="">----</option>
                                                <?php foreach ($ap_emp as $row) : ?>
                                                <?php if ($row['user_id'] == $data['ap_emp']) : ?>
                                                <option value="<?php echo $row['user_id'] ?>" selected="selected"><?php echo $row['emp_code'].' - '.$row['fullname'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $row['user_id'] ?>"><?php echo $row['emp_code'].' - '.$row['fullname'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control" id="ap_dept" name="ap_dept" data-parsley-required="true">
                                                <option value="">----</option>
                                                <?php foreach ($ap_dept as $row) : ?>
                                                <?php if ($row['id'] == $data['ap_dept']) : ?>
                                                <option value="<?php echo $row['id'] ?>" selected="selected"><?php echo $row['code'].' - '.$row['name'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['code'].' - '.$row['name'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="xx_ap_emp_2">
                                        <div class="form-group">
                                            <label>Second Person Responsible</label>
                                            <select class="form-control" id="ap_emp_2" name="ap_emp_2">
                                                <option value="">----</option>
                                                <?php foreach ($ap_emp_2 as $row) : ?>
                                                <?php if ($row['user_id'] == $data['ap_emp_2']) : ?>
                                                <option value="<?php echo $row['user_id'] ?>" selected="selected"><?php echo $row['emp_code'].' - '.$row['fullname'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $row['user_id'] ?>"><?php echo $row['emp_code'].' - '.$row['fullname'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="xx_ap_dept2" style="display:none;">
                                        <div class="form-group">
                                            <label>Second Department</label>
                                            <select class="form-control" id="ap_dept_2" name="ap_dept_2">
                                                <option value="">----</option>
                                                <?php foreach ($ap_dept_2 as $row) : ?>
                                                <?php if ($row['id'] == $data['ap_dept_2']) : ?>
                                                <option value="<?php echo $row['id'] ?>" selected="selected"><?php echo $row['code'].' - '.$row['name'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['code'].' - '.$row['name'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;margin-top: 10px;">Assigned Audit / Project Name</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <Label>Assigned Audit</label>
                                            <select class="form-control" id="ap_assigned_audit" name="ap_assigned_audit" data-parsley-required="true" required>
                                                <option value="">----</option>
                                                <?php foreach ($ap_oldusers as $row) : ?>
                                                <?php if ($row['user_id'] == $data['ap_assigned_audit']) : ?>
                                                <option value="<?php echo $row['user_id']?>"selected="selected"><?php echo $row['audit_staff'] ?></option>
                                                <?php else:?>
                                                <option value="<?php echo $row['user_id']?>"><?php echo $row['audit_staff'] ?></option>
                                                <?php endif;?>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <select class="form-control" id="ap_project_id" name="ap_project_id" data-parsley-required="true" required>
                                                <option value="">----</option>
                                                <?php foreach ($ap_project as $row) : ?>
                                                <?php if ($row['id'] == $data['ap_project_id']) : ?>
                                                <option value="<?php echo $row['id']?>"selected="selected"><?php echo $row['description'] ?></option>
                                                <?php else:?>
                                                <option value="<?php echo $row['id']?>"><?php echo $row['description'] ?></option>
                                                <?php endif;?>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="row">
                                    <div class="col-md-6">
                                        <label>Impact/Value</label>
                                        <?php if ($data['ap_impact_value'] == ""): ?>
                                        <input class="form-control" type="text" id="ap_impact_value" name="ap_impact_value" maxlength="16" placeholder="Enter Impact value"/>
                                        <?php else: ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Impact/Value</label>
                                        <input class="form-control" type="text" id="ap_impact_value2" name="ap_impact_value" maxlength="16" placeholder="Enter Impact value" value="<?php echo number_format($data['ap_impact_value'], 2, ".",",");  ?>"/>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="apimpact_remarks" style="display:none;">
                                        <label>Impact Computation Basis</label>
                                        <?php if ($data['ap_impact_remarks'] == ""): ?>
                                        <textarea class="textarea form-control" id="ap_impact_remarks" name="ap_impact_remarks" rows="5" disabled placeholder="Enter Impact Computation"></textarea>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-12" id="xapimpact_remarks2" style="display:none;">
                                        <label>Impact Computation Basis</label>
                                        <textarea class="textarea form-control" id="xap_impact_remarks2" name="ap_impact_remarks" rows="5" placeholder="Enter Impact Computation"><?php echo $data['ap_impact_remarks'] ?></textarea>
                                    </div>
                                </div>-->
                                <!--end row -->
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Status / Date Tagged as implemented</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" id="_status">
                                            <label>Status</label>
                                            <select class="form-control" id="ap_status" name="ap_status" data-parsley-required="true" required>
                                                <option value="">--</option>
                                                <?php foreach ($ap_status as $ap_status) : ?>
                                                <?php if ($ap_status['id'] == $data['ap_status']) : ?>
                                                <option value="<?php echo $ap_status['id'] ?>" selected="selected"><?php echo $ap_status['status_code'].' - '.$ap_status['status_name'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $ap_status['id']?>"><?php echo $ap_status['status_code'].' - '.$ap_status['status_name'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" id="_tags">
                                            <label>Date tag as Implemented</label>
                                            <?php if ($data['ap_date_tag'] == null): ?>
                                            <input style="width: 220px;" class="btn btn-success btn-xs" type="text" id="ap_date_tag" name="ap_date_tag" value="<?php echo $data['ap_date_tag'] ?>" readonly="readonly"/>
                                            <?php else: ?>
                                            <input style="width: 220px;" class="btn btn-success btn-xs" type="text" id="ap_date_tag" name="ap_date_tag" value="<?php echo date('F j\, Y \ l', strtotime($data['ap_date_tag'])) ?>" readonly="readonly"/>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Due Dates</legend>
                                <!--begin row-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Due Date</label>
                                        <div class="input-group date" id="default">
                                            <input type="text" class="btn btn-success btn-xs" id="ap_due_date" name="ap_due_date" value="<?php echo date('m/d/Y', strtotime($data['ap_due_date'])) ?>" placeholder="mm-dd-yyyy" maxlength="10" readonly="readonly"/>
                                        </div>
                                        <div class="input-group date" id="xdue_date" style="display:none">
                                            <input type="text" class="btn btn-success btn-xs datedayspicker" id="ap_due_date1" name="ap_due_date" placeholder="mm-dd-yyyy" maxlength="10" value="<?php echo date('m/d/Y', strtotime($data['ap_due_date'])) ?>"/>
                                        </div>
                                        <div class="input-group date" id="xdue_date2" style="display:none">
                                            <input type="text" class="btn btn-success btn-xs datedayspicker2" id="ap_due_date2" name="ap_due_date" disabled placeholder="mm-dd-yyyy" maxlength="10" value="<?php echo date('m/d/Y', strtotime($data['ap_due_date'])) ?>"/>
                                        </div>
                                        <div class="input-group date" id="xdue_date3" style="display:none">
                                            <input type="text" class="btn btn-success btn-xs datedayspicker3" id="ap_due_date3" name="ap_due_date" disabled placeholder="mm-dd-yyyy" maxlength="10" value="<?php echo date('m/d/Y', strtotime($data['ap_due_date'])) ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Revised Due Date</label>
                                        <div class="input-group date">
                                            <?php if ($data['ap_date_revised'] == null): ?>
                                            <input type="text" class="btn btn-success btn-xs datedayspicker" id="ap_date_revised" name="ap_date_revised" placeholder="mm-dd-yyyy" maxlength="10" value="<?php echo $data['ap_date_revised'] ?>"/>
                                            <?php else: ?>
                                            <input type="text" class="btn btn-success btn-xs datedayspicker" id="ap_date_revised" name="ap_date_revised" placeholder="mm-dd-yyyy" maxlength="10" value="<?php echo date('m/d/Y', strtotime($data['ap_date_revised'])) ?>"/>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="_dateimplement">
                                        <label>Date Implemented</label>
                                        <div class="input-group date" id="ap_date_implemented1">
                                            <?php if ($data['ap_date_implemented'] == null): ?>
                                            <input type="text" class="btn btn-success btn-xs" name="ap_date_implemented" id="ap_date_implemented" value="<?php echo $data['ap_date_implemented'] ?>" placeholder="mm-dd-yyyy" maxlength="10" readonly="readonly"/>
                                            <?php else: ?>
                                            <input type="text" class="btn btn-success btn-xs datedayspicker" name="ap_date_implemented" id="ap_date_implementedxx" value="<?php echo date('m/d/Y', strtotime($data['ap_date_implemented'])) ?>" placeholder="mm-dd-yyyy" maxlength="10" readonly="readonly"/>
                                            <?php endif; ?>
                                        </div>
                                        <div class="input-group date" id="ap_date_implemented2" style="display:none">
                                            <input type="text" class="btn btn-success btn-xs datedayspicker3" name="ap_date_implemented" id="ap_date_implementedx" placeholder="mm-dd-yyyy" maxlength="10" readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row-form-booking pull-right">
                                                <button type="button" class="btn btn-success btn-sm" id="saveactionbottom" name="saveactionbottom" value="updsaveactionbottomateap" style="margin-top : 12px;">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <!-- end wizard step-2-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('script_foredit.php'); ?>

<script>

//Save
$("#saveaction").click(function() {
    var confirm = window.confirm('Do you want to update this Action Plan?');

    if(confirm)
    {

      {
          //alert ("Successfully save");
          $('#formsave').submit();

      }
      return true;
    }
    else {
        alert('Are you sure you want to cancel');
        //redirect('entry/newdata');
      return false;
    }
});
//end
//Save bottom
$("#saveactionbottom").click(function() {
    var confirm = window.confirm('Do you want to update this Action Plan?');

    if(confirm)
    {

      {
          //alert ("Successfully save");
          $('#formsave').submit();

      }
      return true;
    }
    else {
        alert('Are you sure you want to cancel');
        //redirect('entry/newdata');
      return false;
    }
});
//end

$(".delete").click(function() {
    var confirm = window.confirm('Do you want to untagged?');

    if(confirm)
    {

      {
          alert ("Successfully untagged");

      }
      return true;
    }
    else {
        alert('Are you sure you want to cancel');
        //redirect('entry/newdata');
      return false;
    }
});
</script>
