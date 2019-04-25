
<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('entry/newdata')?>">Home</a></li>
    <li class="active">Transaction</li>
    <li><a href="<?php echo site_url('entry/businessconcern')?>">Business Concern Records</li>
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
                <h4 class="panel-title">View Business Concern - <?php echo $this->session->userdata('sess_company_name');?></h4>
            </div>
            <div class="panel-body">
                <form action="#]" method="post" data-parsley-validate="true" name="form-wizard" name="formsave" id="formsave">
                    <div id="wizard">
                        <ol style="padding: 0px;">
                            <li>
                                <label> Business Concern </label> <!--Step 1 -->
                            </li>
                        </ol>
                        <div class="wizard-step-1">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-2" id="_entereddate">
                                        <div class="form-group">
                                            <label style="font-size: 12px;font-weight: bold;">Date Entered</label>
                                            <input style="width: 200px" class="btn btn-success btn-xs" type="text" name="entered_date" id="entered_date" value="<?php echo date('F j\, Y \ l', strtotime($data['bc_entered_date'])); ?>" readonly="readonly" style="width: 180px;"/>
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
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <Label>Business Code:</label>
                                            <input class="form-control" type="text" id="code" name="code" value="<?php echo $data['bc_code'] ?>" readonly="readonly" data-parsley-required="true" required>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <Label>Action Code:</label>
                                            <?php foreach ($apcodescount as $rowx) : ?>
                                                <?php foreach ($apcodes as $row) : ?>
                                                <?php if ($rowx['apidcount'] >= 2) : ?>
                                                <a href="<?php echo site_url('entry/editAction').'/'.$row['apid'].'/'.$row['code']?>" title="View" target="_blank"><?php echo $row['code'] ?></a>
                                                <a href="<?php echo site_url('entry/removetagging/'.$row['apid'].'/'.$row['bcid'])?>" type="submit" title="untagged" class="btn btn-xs btn-icon btn-circle btn-danger delete"><i class="fa fa-times"></i></a>
                                                <?php elseif ($row['apis_approved'] == 0) : ?>
                                                <a href="<?php echo site_url('entry/editAction').'/'.$row['apid'].'/'.$row['code']?>" title="View" target="_blank"><?php echo $row['code'] ?></a>
                                                <?#php if ($canUNTAGGED) : ?>
                                                <?#php endif;?>
                                                <?php elseif ($row['apis_approved'] == 2) : ?>
                                                <a href="<?php echo site_url('entry/viewap').'/'.$row['apid']?>" title="View" target="_blank"><?php echo $row['code']?></a>
                                                <?#php if ($canUNTAGGED) : ?>
                                                <a href="<?php echo site_url('entry/removetagging/'.$row['apid'].'/'.$row['bcid'])?>" type="submit" title="untagged" class="btn btn-xs btn-icon btn-circle btn-danger delete"><i class="fa fa-times"></i></a>
                                                <?#php endif;?>
                                                <?php else: ?>
                                                <a href="<?php echo site_url('entry/editActionfa').'/'.$row['apid']?>" title="View" target="_blank"><?php echo $row['code'] ?></a>
                                                <?#php if ($canUNTAGGED) : ?>
                                                <a href="<?php echo site_url('entry/removetagging/'.$row['apid'].'/'.$row['bcid'])?>" type="submit" title="untagged" class="btn btn-xs btn-icon btn-circle btn-danger delete"><i class="fa fa-times"></i></a>
                                                <?#php endif;?>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;"></legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <Label>Business Concern:</label>
                                            <textarea class="textarea form-control" id="business_concern" name="business_concern" placeholder="Enter Business Concern ..." rows="8" data-parsley-group="wizard-step-1" data-parsley-required="true" required><?php echo $data['business_concern'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;margin-top: 10px;">Department Details / Employees Responsibles</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Person Responsible</label>
                                            <select class="form-control" name="emp" id="emp" data-parsley-group="wizard-step-1" data-parsley-required="true">
                                                <?php foreach ($bc_emp as $emp) : ?>
                                                <?php if ($emp['user_id'] == $data['emp']) : ?>
                                                <option value="<?php echo $emp['user_id'] ?>" selected="selected"><?php echo $emp['emp_code'].' - '.$emp['fullname'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control" name="dept" id="dept" data-parsley-group="wizard-step-1" data-parsley-required="true">
                                                <?php foreach ($bc_dept as $dept) : ?>
                                                <?php if ($dept['id'] == $data['dept']) : ?>
                                                <option value="<?php echo $dept['id'] ?>" selected="selected"><?php echo $dept['code'].' - '.$dept['name'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="xx_emp2" style="display:none;">
                                        <div class="form-group">
                                            <label>Second Person Responsible</label>
                                            <select class="form-control" name="emp2" id="emp2">
                                                <?php foreach ($bc_emp_2 as $emp2) : ?>
                                                <?php if ($emp2['user_id'] == $data['emp2']) : ?>
                                                <option value="<?php echo $emp2['user_id'] ?>" selected="selected"><?php echo $emp2['emp_code'].' - '.$emp2['fullname'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="xx_dept2" style="display:none;">
                                        <div class="form-group">
                                            <label>Second Department</label>
                                            <select class="form-control" name="dept2" id="dept2">
                                                <?php foreach ($bc_dept_2 as $dept2) : ?>
                                                <?php if ($dept2['id'] == $data['dept2']) : ?>
                                                <option value="<?php echo $dept2['id'] ?>" selected="selected"><?php echo $dept2['code'].' - '.$dept2['name'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="xx_emp3" style="display:none;">
                                        <div class="form-group">
                                            <label>Third Person Responsible</label>
                                            <select class="form-control" name="emp3" id="emp3">
                                                <?php foreach ($bc_emp_3 as $emp3) : ?>
                                                <?php if ($emp3['user_id'] == $data['emp3']) : ?>
                                                <option value="<?php echo $emp3['user_id'] ?>" selected="selected"><?php echo $emp3['emp_code'].' - '.$emp3['fullname'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="xx_dept3" style="display:none;">
                                        <div class="form-group">
                                            <label>Third Department</label>
                                            <select class="form-control" name="dept3" id="dept3">
                                                <?php foreach ($bc_dept_3 as $dept3) : ?>
                                                <?php if ($dept3['id'] == $data['dept3']) : ?>
                                                <option value="<?php echo $dept3['id'] ?>" selected="selected"><?php echo $dept3['code'].' - '.$dept3['name'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--<--end row-->
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Project Name / Recurring</legend>
                                <!--begin row-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <select class="form-control" name="project_id" id="project_id" data-parsley-group="wizard-step-1" data-parsley-required="true">
                                                <?php foreach ($bc_project as $bc_project) : ?>
                                                <?php if ($bc_project['id'] == $data['project_id']) : ?>
                                                <option value="<?php echo $bc_project['id'] ?>" selected="selected"><?php echo $bc_project['code'].' - '.$bc_project['description'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Recurring:</label>
                                        <div class="col-md-3">
                                            <div class="radio">
                                                <label>
                                                    <?php if ($data['recur'] == 1): ?>
                                                    <input type="radio" value="1" checked="checked" name="recur" id="recur" />
                                                    YES
                                                    <?php else: ?>
                                                    <input type="radio" class="radio" value="1" name="recur" id="recur" />
                                                    YES
                                                    <?php endif; ?>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <?php if ($data['recur'] == 2): ?>
                                                    <input type="radio" value="2" checked="checked"  name="recur" id="recur" />
                                                    NO
                                                    <?php else: ?>
                                                    <input type="radio" class="radio" value="2" name="recur" id="recur" />
                                                    NO
                                                    <?php endif; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Audit Staff</label>
                                            <select class="form-control" name="assigned_audit" id="assigned_audit" data-parsley-group="wizard-step-1" data-parsley-required="true" required>
                                                <option value="">--</option>
                                                <?php foreach ($bc_oldusers as $bc_users) : ?>
                                                <?php if ($bc_users['user_id'] == $data['assigned_audit']) : ?>
                                                <option value="<?php echo $bc_users['user_id'] ?>" selected="selected"><?php echo $bc_users['employee_id'].' - '.$bc_users['audit_staff'] ?></option>
                                                <?php endif; ?>
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
                                            <textarea class="textarea form-control" id="remarks" name="remarks" placeholder="Enter Remarks ..." rows="8"><?php echo $data['remarks']?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Issue</label>
                                            <select class="form-control" id="issue" name="issue" data-parsley-group="wizard-step-1" data-parsley-required="true" required>
                                              <?php foreach ($bc_issues as $bc_issues) : ?>
                                              <?php if ($bc_issues['id'] == $data['issue']) : ?>
                                              <option value="<?php echo $bc_issues['id'] ?>" selected="selected"><?php echo $bc_issues['description'] ?></option>
                                              <?php endif; ?>
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
                                            <?php if ($row['id'] == $data['internal_cc']) : ?>
                                            <option value="<?php echo $row['id'] ?>" selected="selected"><?php echo $row['description'] ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endif; ?>
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
                                            <?php if ($row['id'] == $data['iccomponent']) : ?>
                                            <option value="<?php echo $row['id'] ?>" selected="selected"><?php echo $row['description'] ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Risks</legend>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control" name="risk1" id="risk1" data-parsley-required="true" required>
                                                <?php foreach ($bc_risk as $bc_risk) : ?>
                                                <?php if ($bc_risk['id'] == $data['risk1']) : ?>
                                                <option value="<?php echo $bc_risk['id'] ?>" selected="selected"><?php echo $bc_risk['code'].' - '.$bc_risk['description'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="_risk2" style="display: none;">
                                        <div class="form-group">
                                            <select class="form-control" name="risk2" id="risk2">
                                                <?php foreach ($bc_risk2 as $bc_risk2) : ?>
                                                <?php if ($bc_risk2['id'] == $data['risk2']) : ?>
                                                <option value="<?php echo $bc_risk2['id'] ?>" selected="selected"><?php echo $bc_risk2['code'].' - '.$bc_risk2['description'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="_risk3" style="display: none;">
                                        <div class="form-group">
                                            <select class="form-control" name="risk3" id="risk3">
                                                <?php foreach ($bc_risk3 as $bc_risk3) : ?>
                                                <?php if ($bc_risk3['id'] == $data['risk3']) : ?>
                                                <option value="<?php echo $bc_risk3['id'] ?>" selected="selected"><?php echo $bc_risk3['code'].' - '.$bc_risk3['description'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Risk Rating</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Risk Rating</label>
                                            <select class="form-control" name="risk_rating" id="risk_rating" data-parsley-required="true" required>
                                                <?php foreach ($bc_risk_rating as $bc_risk_rating) : ?>
                                                <?php if ($bc_risk_rating['id'] == $data['risk_rating']) : ?>
                                                <option value="<?php echo $bc_risk_rating['id'] ?>" selected="selected"><?php echo $bc_risk_rating['code'].' - '.$bc_risk_rating['description'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Impact/Value</label>
                                            <?php if ($data['impact_value'] == null): ?>
                                            <input class="form-control" type="text" name="impact_value" id="impact_value" maxlength="16" placeholder="Enter Impact value"/>
                                            <?php else: ?>
                                            <input class="form-control" type="text" name="impact_value" id="impact_value2" maxlength="16" placeholder="Enter Impact value" value="<?php echo number_format($data['impact_value'], 2, ".",",");  ?>"/>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" id="edit_impact_remarks" style="display:none;">
                                            <div class="form-group">
                                                <label>Impact Computation Basis</label>
                                                <textarea class="textarea form-control" id="impact_remarks" name="impact_remarks" placeholder="Enter Impact Computation ..." rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="edit_impact_remarks2" style="display:none;">
                                            <label>Impact Computation Basis</label>
                                            <textarea class="textarea form-control ximpact_remarks2" id="impact_remarks_2" name="impact_remarks" placeholder="Enter Impact Computation ..." rows="5" data-parsley-group="wizard-step-1" data-parsley-required="true"><?php echo $data['impact_remarks'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Status / Date Tagged as implemented</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" id="b_status">
                                            <label>Status</label>
                                            <select class="form-control" id="bc_status" name="bc_status"  data-parsley-required="true" required>
                                                <?php foreach ($bc_status as $row) : ?>
                                                <?php if ($row['id'] == $data['bc_status']) : ?>
                                                <option value="<?php echo $row['id'] ?>" selected="selected"><?php echo $row['status_code'].' - '.$row['status_name'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date tag as Implemented</label>
                                            <?php if ($data['date_tag'] == null): ?>
                                            <input style="width: 220px;" class="btn btn-success btn-xs" type="text" name="date_tag" id="date_tag" value="<?php echo $data['date_tag'] ?>" readonly="readonly"/>
                                            <?php else: ?>
                                            <input style="width: 220px;" class="btn btn-success btn-xs" type="text" name="date_tag" id="date_tag" value="<?php echo date('F j\, Y \ l', strtotime($data['date_tag'])) ?>" readonly="readonly"/>
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
                                            <input type="text" class="btn btn-success btn-xs datedayspicker" id="due_date" value="<?php echo date('m-d-Y', strtotime($data['due_date'])) ?>" placeholder="mm-dd-yyyy" name="due_date" data-parsley-required="true" maxlength="10"/>
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>  -->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Revised Due Date</label>
                                        <div class="input-group date">
                                            <?php if ($data['date_revised'] == null): ?>
                                            <input type="text" class="btn btn-success btn-xs datedayspicker" id="date_revised" value="<?php echo $data['date_revised'] ?>" placeholder="mm-dd-yyyy" name="date_revised" maxlength="10"/>
                                            <?php else: ?>
                                            <input type="text" class="btn btn-success btn-xs datedayspicker" id="date_revised" value="<?php echo date('m-d-Y', strtotime($data['date_revised'])) ?>" placeholder="mm-dd-yyyy" name="date_revised" maxlength="10"/>
                                            <?php endif; ?>
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Date Resolved</label>
                                        <div class="input-group date" id="d_implemented1">
                                            <?php if ($data['date_implemented'] == null): ?>
                                            <input type="text" class="btn btn-success btn-xs" id="xdate_implemented" name="xdate_implemented" value="<?php echo date($data['date_implemented'])?>" placeholder="mm-dd-yyyy" maxlength="10" readonly="readonly"/>
                                            <?php else: ?>
                                            <input type="text" class="btn btn-success btn-xs datedayspicker" id="xdate_implementedx" name="xdate_implemented" value="<?php echo date('m-d-Y', strtotime($data['date_implemented'])) ?>" placeholder="mm-dd-yyyy" maxlength="10" readonly="readonly"/>
                                            <?php endif; ?>
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                                        </div>
                                        <div class="input-group date" id="d_implemented2" style="display:none">
                                            <input type="text" class="btn btn-success btn-xs datedayspicker" id="xdate_implemented2" name="xdate_implemented" placeholder="mm-dd-yyyy" maxlength="10"/>
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                                        </div>

                                    </div>
                                </div>
                          </fieldset>
                        </div>
                        <!--end wizard step-1-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
