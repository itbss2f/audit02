
<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('entry/newdata')?>">Home</a></li>
    <li class="active">Transaction</li>
    <li><a href="<?php echo site_url('entry/listofBusinessofConcern')?>">Business Concern Records</li>
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
                <h4 class="panel-title">Add New Business Concern - <?php echo $this->session->userdata('sess_company_name');?></h4>
            </div>
            <div class="panel-body">
                <form action="<?php echo site_url('entry/savebusinessconcern') ?>" method="post" data-parsley-validate="true" name="form-wizard" name="formsave" id="formsave">
                    <div id="wizard">
                        <ol style="padding: 0px;">
                            <li>
                                <label> Action Plan </label>    <!--Step 2 -->
                            </li>
                            <li>
                                <label> Business Concern </label> <!--Step 1-->
                            </li>
                        </ol>
                        <div class="wizard-step-1">
                            <fieldset>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Action Plan</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <Label style="font-size: 12px;font-weight: bold;">Date Entered</label>
                                            <input class="btn btn-success btn-xs" type="text" name="entered_date" id="entered_date" value="<?php echo date('F j\, Y \ l', strtotime($data['ap_entered_date'])); ?>" readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <!--begin row-->
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <Label>Action Code:</label>
                                            <input class="form-control" type="text" id="code" name="code" value="<?php echo $data['code'] ?>" readonly="readonly" data-parsley-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!--<label>ACtion Plan:</label>-->
                                            <textarea class="form-control" id="action_plan" name="action_plan" placeholder="Enter Action Plan ..." rows="8" data-parsley-group="wizard-step-1" data-parsley-required="true" required readonly="readonly"><?php echo $data['action_plan'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;margin-top: 10px;">Department Details / Employees Responsibles</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Person Responsible</label>
                                            <select class="form-control" id="ap_emp" name="ap_emp" data-parsley-group="wizard-step-1" data-parsley-required="true" readonly="readonly">

                                                <?php foreach ($ap_emp as $row) : ?>
                                                <?php if ($row['user_id'] == $data['ap_emp']) : ?>
                                                <option value="<?php echo $row['user_id'] ?>" selected="selected"><?php echo $row['emp_code'].' - '.$row['fullname'] ?></option>
                                                <!--<?#php else: ?>
                                                <option value="<?#php echo $row['user_id'] ?>"><?#php echo $row['emp_code'].' - '.$row['fullname'] ?></option>-->
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control" id="ap_dept" name="ap_dept" data-parsley-group="wizard-step-1" data-parsley-required="true" readonly="readonly">

                                                <?php foreach ($ap_dept as $row) : ?>
                                                <?php if ($row['id'] == $data['ap_dept']) : ?>
                                                <option value="<?php echo $row['id'] ?>" selected="selected"><?php echo $row['code'].' - '.$row['name'] ?></option>
                                                <!--<?#php else: ?>
                                                <option value="<?#php echo $row['id'] ?>"><?#php echo $row['code'].' - '.$row['name'] ?></option>-->
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Second Person Responsible</label>
                                            <select class="form-control" id="ap_emp_2" name="ap_emp_2" readonly="readonly">

                                                <?php foreach ($ap_emp_2 as $row) : ?>
                                                <?php if ($row['user_id'] == $data['ap_emp_2']) : ?>
                                                <option value="<?php echo $row['user_id'] ?>" selected="selected"><?php echo $row['emp_code'].' - '.$row['fullname'] ?></option>
                                                <!--<?#php else: ?>
                                                <option value="<?#php echo $row['user_id'] ?>"><?#php echo $row['emp_code'].' - '.$row['fullname'] ?></option>-->
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Second Department</label>
                                            <select class="form-control" id="ap_dept_2" name="ap_dept_2" readonly="readonly">

                                                <?php foreach ($ap_dept_2 as $row) : ?>
                                                <?php if ($row['id'] == $data['ap_dept_2']) : ?>
                                                <option value="<?php echo $row['id'] ?>" selected="selected"><?php echo $row['code'].' - '.$row['name'] ?></option>
                                                <!--<?#php else: ?>
                                                <option value="<?#php echo $row['id'] ?>"><?#php echo $row['code'].' - '.$row['name'] ?></option>-->
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
                                            <select class="form-control" id="ap_assigned_audit" name="ap_assigned_audit" data-parsley-group="wizard-step-1" data-parsley-required="true" required readonly="readonly">

                                                <?php foreach ($ap_oldusers as $row) : ?>
                                                <?php if ($row['user_id'] == $data['ap_assigned_audit']) : ?>
                                                <option value="<?php echo $row['user_id']?>"selected="selected"><?php echo $row['audit_staff'] ?></option>
                                                <!--<?#php else:?>
                                                <option value="<?#php echo $row['user_id']?>"><?#php echo $row['audit_staff'] ?></option>-->
                                                <?php endif;?>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <select class="form-control" id="ap_project_id" name="ap_project_id" data-parsley-group="wizard-step-1" data-parsley-required="true" required readonly="readonly">

                                                <?php foreach ($ap_project as $row) : ?>
                                                <?php if ($row['id'] == $data['ap_project_id']) : ?>
                                                <option value="<?php echo $row['id']?>"selected="selected"><?php echo $row['description'] ?></option>
                                                <!--<?#php else:?>
                                                <option value="<?#php echo $row['id']?>"><?#php echo $row['description'] ?></option>-->
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
                                        <input class="form-control" type="text" id="ap_impact_value" name="ap_impact_value" maxlength="16" placeholder="Enter Impact value" readonly="readonly" disabled="disabled"/>
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
                                        <textarea class="textarea form-control" id="xap_impact_remarks2" name="ap_impact_remarks" rows="5" placeholder="Enter Impact Computation" data-parsley-group="wizard-step-1" data-parsley-required="true"><?php echo $data['ap_impact_remarks'] ?></textarea>
                                    </div>
                                </div>-->
                                <!--end row -->
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Status / Date Tagged as implemented</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" id="_status">
                                            <label>Status</label>
                                            <select class="form-control" id="ap_status" name="ap_status" data-parsley-group="wizard-step-1" data-parsley-required="true" required readonly="readonly">

                                                <?php foreach ($ap_status as $ap_status) : ?>
                                                <?php if ($ap_status['id'] == $data['ap_status']) : ?>
                                                <option value="<?php echo $ap_status['id'] ?>" selected="selected"><?php echo $ap_status['status_code'].' - '.$ap_status['status_name'] ?></option>
                                                <!--<?#php else: ?>
                                                <option value="<?#php echo $ap_status['id']?>"><?#php echo $ap_status['status_code'].' - '.$ap_status['status_name'] ?></option>-->
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" id="_tags">
                                            <label>Date tag as Implemented</label>
                                            <?php if ($data['ap_date_tag'] == null): ?>
                                            <input class="btn btn-success btn-xs" type="text" id="ap_date_tag" name="ap_date_tag" value="<?php echo $data['ap_date_tag'] ?>" readonly="readonly"/>
                                            <?php else: ?>
                                            <input class="btn btn-success btn-xs" type="text" id="ap_date_tag" name="ap_date_tag" value="<?php echo date('F j\, Y \ l', strtotime($data['ap_date_tag'])) ?>" readonly="readonly"/>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Due Dates</legend>
                                <!--begin row-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Due Date</label>
                                        <div class="input-group date">
                                            <input type="text" class="btn btn-success btn-xs" id="ap_due_date" name="ap_due_date" placeholder="mm/dd/yyyy" maxlength="10" value="<?php echo date('m/d/Y', strtotime($data['ap_due_date'])) ?>" data-parsley-required="true" readonly="readonly"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Revised Due Date</label>
                                        <div class="input-group date">
                                            <?php if ($data['ap_date_revised'] == null): ?>
                                            <input type="text" class="btn btn-success btn-xs" id="ap_date_revised" name="ap_date_revised" placeholder="mm/dd/yyyy" maxlength="10" value="<?php echo $data['ap_date_revised'] ?>" readonly="readonly"/>
                                            <?php else: ?>
                                            <input type="text" class="btn btn-success btn-xs" id="ap_date_revised" name="ap_date_revised" placeholder="mm/dd/yyyy" maxlength="10" value="<?php echo date('m/d/Y', strtotime($data['ap_date_revised'])) ?>" readonly="readonly"/>
                                            <?php endif; ?>
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="_dateimplement">
                                        <label>Date Implemented</label>
                                        <div class="input-group date">
                                            <?php if ($data['ap_date_implemented'] == null): ?>
                                            <input type="text" class="btn btn-success btn-xs" id="ap_date_implemented" name="ap_date_implemented" placeholder="mm/dd/yyyy" maxlength="10" value="<?php echo $data['ap_date_implemented'] ?>" readonly="readonly"/>
                                            <?php else: ?>
                                            <input type="text" class="btn btn-success btn-xs" id="ap_date_implemented" name="ap_date_implemented" placeholder="mm/dd/yyyy" maxlength="10" value="<?php echo date('m/d/Y', strtotime($data['ap_date_implemented'])) ?>" readonly="readonly"/>
                                            <?php endif; ?>
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="wizard-step-2">
                            <fieldset>
                                <div class="row">
                                    <div class="row-form-booking pull-right">
                                        <button type="save" class="btn btn-success btn-sm" id="upupdate" name="upupdate" value="upupdate">Save Update</button>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label style="font-size: 12px;font-weight: bold;">Date Entered</label>
                                            <input style="width: 200px;" class="btn btn-success btn-xs" type="text" id="entered_date" name="entered_date" value="<?php echo date('F j\, Y \ l')  ?>" readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;"></legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label style="font-size: 12px;font-weight: bold;">Business Concern Code</label>
                                            <input class="form-control" type="text" id="bc_code" name="bc_code" value="<?php echo "FA".substr(md5(uniqid(mt_rand(), true)), 0, 4)?>" readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <Label>Business Concern:</label>
                                            <textarea class="textarea form-control" id="business_concern" name="business_concern" placeholder="Enter Business Concern ..." rows="8" data-parsley-required="true" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;margin-top: 10px;">Department Details / Employees Responsibles</legend>
                                <div class="row">
                                    <div class="form-group">
                                        <input class="form-control" type="hidden" id="company" name="company" value="<?php echo $this->session->userdata('sess_company');?>"/>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Person Responsible</label>
                                            <select class="form-control" id="emp" name="emp" data-parsley-required="true"/>
                                            <option value="">----</option>
                                            <?php foreach ($bc_emp as $row) : ?>
                                            <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control" name="dept" id="dept" data-parsley-required="true" required/>
                                            <option value="">----</option>
                                            <?php foreach ($bc_dept as $row) : ?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['name'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="xx_emp2" style="display:none;">
                                        <div class="form-group">
                                            <label>Second Person Responsible</label>
                                            <select class="form-control" id="emp2" name="emp2">
                                            <option value="">----</option>
                                            <?php foreach ($bc_emp_2 as $row) : ?>
                                            <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="xx_dept2" style="display:none;">
                                        <div class="form-group">
                                            <label>Second Department</label>
                                            <select class="form-control" name="dept2" id="dept2"/>
                                            <option value="">----</option>
                                            <?php foreach ($bc_dept_2 as $row) : ?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['name'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="xx_emp3" style="display:none;">
                                        <div class="form-group">
                                            <label>Third Person Responsible</label>
                                            <select class="form-control" id="emp3" name="emp3">
                                            <option value="">----</option>
                                            <?php foreach ($bc_emp_3 as $row) : ?>
                                            <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="xx_dept3" style="display:none;">
                                        <div class="form-group">
                                            <label>Third Department</label>
                                            <select class="form-control" name="dept3" id="dept3"/>
                                            <option value="">----</option>
                                            <?php foreach ($bc_dept_3 as $row) : ?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['name'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Project Name / Recurring</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <select class="form-control" id="project_id" name="project_id" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($bc_project as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="recur" data-parsley-required="true" required readonly="readonly" disabled="disabled">
                                                     Recurring:
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" value="1" name="recur" style="margin-top: 1px;"/>
                                                    YES
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" value="2" name="recur" style="margin-top: 1px;"/>
                                                    NO
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <Label>Assigned Audit</label>
                                            <select class="form-control" id="assigned_audit" name="assigned_audit" data-parsley-required="true" required>
                                                <option value="">----</option>
                                                <?php foreach ($bc_users as $row) : ?>
                                                <option value="<?php echo $row['user_id'] ?>"><?php echo $row['audit_staff'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Issues</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <Label>Issue Remarks:</label>
                                            <textarea class="textarea form-control" id="remarks" name="remarks" placeholder="Enter Remarks ..." rows="8"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Issue</label>
                                            <select class="form-control" id="issue" name="issue" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($bc_issues as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Internal Control Component/IC Component Principle</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Internal CC</label>
                                            <select class="form-control" id="internal_cc" name="internal_cc">
                                            <option value="">----</option>
                                            <?php foreach ($bc_internal_cc as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>IC Component Principle</label>
                                            <select class="form-control" id="iccomponent" name="iccomponent">
                                            <option value="">----</option>
                                            <?php foreach ($bc_iccomponents as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Risks</legend>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Risk 1</label>
                                        <div class="form-group">
                                            <select class="form-control" id="risk1" name="risk1" data-parsley-required="true">
                                            <option value="">------</option>
                                            <?php foreach ($bc_risk as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="_risk2" style="display: none;">
                                        <label>Risk 2</label>
                                        <div class="form-group">
                                            <select class="form-control" id="risk2" name="risk2">
                                            <option value="">------</option>
                                            <?php foreach ($bc_risk2 as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="_risk3" style="display: none;">
                                        <label>Risk 3</label>
                                        <div class="form-group">
                                            <select class="form-control" id="risk3" name="risk3">
                                            <option value="">------</option>
                                            <?php foreach ($bc_risk3 as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Risk Rating</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Risk Rating</label>
                                        <div class="form-group">
                                            <select class="form-control" id="risk_rating" name="risk_rating" data-parsley-required="true">
                                            <option value="">----</option>
                                            <?php foreach ($bc_risk_rating as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Impact/Value</label>
                                            <input class="form-control" type="text" name="impact_value" id="impact_value" value="" maxlength="16" placeholder="Enter Impact value"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="x_impact_remarks" style="display:none;">
                                        <label>Impact Computation Basis</label>
                                        <textarea class="textarea form-control ximpact_remarks" id="impact_remarks" name="impact_remarks" disabled placeholder="Enter Impact Computation ..." rows="5"></textarea>
                                    </div>
                                    <div class="col-md-12" id="x_impact_remarks2" style="display:none;">
                                        <label>Impact Computation Basis</label>
                                        <textarea class="textarea form-control ximpact_remarks2" id="impact_remarks_2" name="impact_remarks" placeholder="Enter Impact Computation ..." rows="5" value="0.00" data-parsley-required="true"></textarea>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Status / Date Tagged as implemented</legend>
                                <div class="row">
                                    <div class="col-md-6" id="b_status">
                                        <label>Status</label>
                                        <?php if ($data['ap_status'] != 2 || $data['ap_is_approved'] != 0): ?>
                                            <select class="form-control" id="bc_status" name="bc_status"  data-parsley-required="true">
                                                <?php foreach ($bc_status2 as $row) : ?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['status_code'].' - '.$row['status_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php else :?>
                                            <select class="form-control" id="bc_status" name="bc_status"  data-parsley-required="true" required>
                                                <?php foreach ($bc_status as $row) : ?>
                                                <option value="<?php echo $row['id']?>"><?php echo $row['status_code'].' - '.$row['status_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Date tagged as Resolved</label>
                                            <input class="btn btn-success btn-xs" type="text" name="date_tag" id="date_tag" readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Due Dates</legend>
                                <div class="row">
                                    <div class="col-md-6" id="_due_date">
                                        <Label>Due Date</label>
                                        <div class="input-group date datedayspicker">
                                            <input type="text" class="btn btn-success btn-xs" id="due_date" name="due_date" style="font-weight: bold;" placeholder="mm-dd-yyyy" data-parsley-required="true" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                         <label>Date Resolved</label>
                                        <div class="input-group date" id="d_implemented1">
                                          <input type="text" class="btn btn-success btn-xs" id="date_implemented" name="date_implemented" style="font-weight: bold;" placeholder="mm-dd-yyyy" readonly="readonly">
                                        </div>
                                        <div class="input-group date datedayspicker3" id="d_implemented2" style="display:none">
                                          <input type="text" class="btn btn-success btn-xs" id="date_implementedx" name="date_implemented" style="font-weight: bold;" placeholder="mm-dd-yyyy" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row-form-booking pull-right">
                                            <button type="save" class="btn btn-success btn-sm" id="bottomupdate" name="bottomupdate" value="bottomupdate" style="margin-top : 12px;">Save Update</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('script_foradd.php'); ?>

<script>

$("#bottomupdate").click(function() {
    var confirm = window.confirm('Are you sure you want to save?');

    if(confirm)
    {
        $('#formsave').submit();
    }
    else {
        alert('Are you sure you want to cancel');
    }
});

$("#upupdate").click(function() {
    var confirm = window.confirm('Are you sure you want to save?');

    if(confirm)
    {
        $('#formsave').submit();
    }
    else {
        alert('Are you sure you want to cancel');
    }
});
</script>
