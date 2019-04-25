
<div class="breadcrumb pull-right">
    <li><a href="<?php echo site_url('entry_risk/new_entry')?>">Home</a></li>
    <li class="active">Transaction</li>
    <li><a href="<?php echo site_url('entry_risk/listforApproval')?>">Accepted Risks Records</li>
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
                <h4 class="panel-title">Edit Accepted Risk for Approval - <?php echo $this->session->userdata('sess_company_name');?></h4>
            </div> 
            <div class="panel-body">  
                <form action="<?php echo site_url('entry_risk/updateactionfa/'.$data['id']) ?>" method="post" data-parsley-validate="true" name="form-wizard" name="formsave" id="formsave">
                    <div id="wizard">
                        <ol style="padding: 0px;">
                            <li>
                                <label> Action Plan </label> <!--Step 1 -->                              
                            </li>
                             <li>
                                <label> Issues / Status </label>    <!--Step 2 -->                              
                            </li>
                        </ol>
                        <!--begin wizard step-1-->
                        <div class="wizard-step-1">
                            <fieldset>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-2" id="_entereddate">
                                        <div class="form-group">
                                            <label style="font-size: 12px;font-weight: bold;">Date Entered</label>                                                                                                 
                                            <input style="width: 200px" class="btn btn-success btn-xs" type="text" name="entered_date" id="entered_date" value="<?php echo date('F j\, Y \ l', strtotime($data['entered_date'])); ?>" readonly="readonly" style="width: 180px;"/>
                                        </div>
                                    </div>
                                    <!--end row-->
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label style="font-size: 12px;font-weight: bold;"></label>
                                            <input class="btn btn-success btn-xs" type="hidden" id="code" name="code" value="<?php echo $data['code'] ?>" readonly="readonly">
                                        </div>    
                                    </div> 
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label style="font-size: 12px;font-weight: bold;">Company</label>
                                            <input class="btn btn-success btn-xs" style="width: 250px;" type="text" value="<?php echo $data['company_name'] ?>" readonly="readonly">   
                                        </div> 
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Business Concern</legend> 
                                <div class="row">    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Action Plan</label>
                                            <textarea class="textarea form-control" rows="8" style="width: 908px;" title="action_plan" id="action_plan" name="action_plan" placeholder="Enter Action Plan ..." data-parsley-group="wizard-step-1" data-parsley-required="true" required><?php echo $data['action_plan'] ?></textarea> 
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;margin-top: 10px;">Department Details / Employees Responsibles</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Person Responsible</label>
                                            <select class="form-control" name="emp" id="emp" style="width: 408px;" data-parsley-group="wizard-step-1" data-parsley-required="true">
                                                <option value="">----</option>
                                                <?php foreach ($emp as $emp) : ?> 
                                                <?php if ($emp['user_id'] == $data['emp']) : ?>  
                                                <option value="<?php echo $emp['user_id'] ?>" selected="selected"><?php echo $emp['fullname'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $emp['user_id'] ?>"><?php echo $emp['fullname'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>    
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control" name="dept" id="dept" style="width: 436px;" data-parsley-group="wizard-step-1" data-parsley-required="true">
                                                <option value="">----</option>
                                                <?php foreach ($dept as $dept) : ?> 
                                                <?php if ($dept['id'] == $data['dept']) : ?>  
                                                <option value="<?php echo $dept['id'] ?>" selected="selected"><?php echo $dept['code'].' - '.$dept['name'] ?></option>    
                                                <?php else: ?>
                                                <option value="<?php echo $dept['id'] ?>"><?php echo $dept['code'].' - '.$dept['name'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>    
                                        </div>
                                    </div>
                                </div>
                                <!--end of row-->
                                <!--begin row--> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Second Person Responsible</label>    
                                            <select class="form-control" name="emp2" id="emp2" style="width: 408px;">
                                                <option value="">----</option>
                                                <?php foreach ($emp_2 as $emp_2) : ?> 
                                                <?php if ($emp_2['user_id'] == $data['emp2']) : ?>  
                                                <option value="<?php echo $emp_2['user_id'] ?>" selected="selected"><?php echo $emp_2['fullname'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $emp_2['user_id'] ?>"><?php echo $emp_2['fullname'] ?></option>
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
                                            <select class="form-control" name="project_id" id="project_id" style="width: 408px;" data-parsley-group="wizard-step-1" data-parsley-required="true">
                                                <option value="">--</option>
                                                <?php foreach ($ap_project as $ap_project) : ?> 
                                                <?php if ($ap_project['id'] == $data['project_id']) : ?>  
                                                <option value="<?php echo $ap_project['id'] ?>" selected="selected"><?php echo $ap_project['code'].' - '.$ap_project['description'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $ap_project['id']?>"><?php echo $ap_project['code'].' - '.$ap_project['description'] ?></option>          
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
                                            <select class="form-control" name="assigned_audit" id="assigned_audit" style="width: 408px;" data-parsley-group="wizard-step-1" data-parsley-required="true" required>
                                                <option value="">--</option>
                                                <?php foreach ($ap_oldusers as $ap_oldusers) : ?> 
                                                <?php if ($ap_oldusers['user_id'] == $data['assigned_audit']) : ?>  
                                                <option value="<?php echo $ap_oldusers['user_id'] ?>" selected="selected"><?php echo $ap_oldusers['employee_id'].' - '.$ap_oldusers['audit_staff'] ?></option>
                                                <?php endif; ?> 
                                                <?php endforeach; ?>
                                                <?php foreach ($ap_users as $ap_users) : ?>
                                                <?php if ($ap_users['user_id'] == $ap_users['user_id']) : ?> 
                                                <option value="<?php echo $ap_users['user_id']?>"><?php echo $ap_users['employee_id'].' - '.$ap_users['audit_staff'] ?></option>
                                                <?php endif; ?> 
                                                <?php endforeach; ?>
                                            </select>    
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <!--end wizard step-1-->
                        <!--begin wizard step-2-->
                        <div class="wizard-step-2">
                            <fieldset>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Issue Details / Business Concern</legend>
                                <!--begin row-->    
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Issue</label>
                                            <select class="form-control" name="issue" id="issue" style="width: 302px;" data-parsley-required="true" required>
                                                <option value="">--</option>
                                                <?php foreach ($ap_issue as $ap_issue) : ?> 
                                                <?php if ($ap_issue['id'] == $data['issue']) : ?>  
                                                <option value="<?php echo $ap_issue['id'] ?>" selected="selected"><?php echo $ap_issue['code'].' - '.$ap_issue['description'] ?></option>    
                                                <?php else: ?>
                                                <option value="<?php echo $ap_issue['id'] ?>"><?php echo $ap_issue['code'].' - '.$ap_issue['description'] ?></option>        
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>         
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Issue Remarks</label> 
                                            <textarea class="textarea form-control" rows="8" id="remarks" name="remarks" style="width: 302px;" placeholder="Enter Remarks ..."><?php echo $data['remarks'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <Label>Business Concern:</label>
                                            <textarea class="textarea form-control" id="issue_remarks" name="issue_remarks" style="width: 280px;" placeholder="Enter Business Concern ..." rows="8"><?php echo $data['issue_remarks']?></textarea> 
                                        </div>
                                    </div> 
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Risk</legend> 
                                <!--begin row-->            
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control" name="risk1" id="risk1" style="width: 302px;" data-parsley-required="true" required>
                                                <option value="">-------</option>
                                                <?php foreach ($ap_risk as $ap_risk) : ?> 
                                                <?php if ($ap_risk['id'] == $data['risk1']) : ?>  
                                                <option value="<?php echo $ap_risk['id'] ?>" selected="selected"><?php echo $ap_risk['code'].' - '.$ap_risk['description'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $ap_risk['id'] ?>"><?php echo $ap_risk['code'].' - '.$ap_risk['description'] ?></option> 
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>        
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control" name="risk2" id="risk2" style="width: 302px;">
                                                <option value="">-------</option>
                                                <?php foreach ($ap_risk2 as $ap_risk2) : ?> 
                                                <?php if ($ap_risk2['id'] == $data['risk2']) : ?>  
                                                <option value="<?php echo $ap_risk2['id'] ?>" selected="selected"><?php echo $ap_risk2['code'].' - '.$ap_risk2['description'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $ap_risk2['id'] ?>"><?php echo $ap_risk2['code'].' - '.$ap_risk2['description'] ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <select class="form-control" name="risk3" id="risk3" style="width: 280px;">
                                                <option value="">-------</option>
                                                <?php foreach ($ap_risk3 as $ap_risk3) : ?> 
                                                <?php if ($ap_risk3['id'] == $data['risk3']) : ?>  
                                                <option value="<?php echo $ap_risk3['id'] ?>" selected="selected"><?php echo $ap_risk3['code'].' - '.$ap_risk3['description'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $ap_risk3['id'] ?>"><?php echo $ap_risk3['code'].' - '.$ap_risk3['description'] ?></option>
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
                                            <select class="form-control" name="risk_rating" id="risk_rating" style="width: 408px;" data-parsley-required="true" required>
                                                <option value="">--</option>
                                                <?php foreach ($ap_risk_rating as $ap_risk_rating) : ?> 
                                                <?php if ($ap_risk_rating['id'] == $data['risk_rating']) : ?>  
                                                <option value="<?php echo $ap_risk_rating['id'] ?>" selected="selected"><?php echo $ap_risk_rating['code'].' - '.$ap_risk_rating['description'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $ap_risk_rating['id']?>"><?php echo $ap_risk_rating['code'].' - '.$ap_risk_rating['description'] ?></option>         
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
                                            <input class="form-control" type="text" name="impact_value" id="impact_value" maxlength="16" style="width: 436px;" placeholder="Enter Impact value" value="0.00"/>
                                            <?php else: ?>
                                            <input class="form-control" type="text" name="impact_value" id="impact_value" maxlength="16" style="width: 436px;" placeholder="Enter Impact value" value="<?php echo number_format($data['impact_value'], 2, ".",",");  ?>"/>
                                            <?php endif; ?>      
                                        </div>         
                                    </div>          
                                </div>
                                <!-- end row -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Impact Computation Basis</label>
                                            <textarea class="textarea form-control" id="impact_remarks" name="impact_remarks" style="width: 908px;" placeholder="Enter Impact Computation ..." rows="5"><?php echo $data['impact_remarks'] ?></textarea>
                                        </div>         
                                    </div>         
                                </div>
                                <!--end row -->
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Status / Date Tagged as implemented</legend>
                                <!-- begin row --> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" id="_status">
                                            <label>Status</label>
                                            <select class="form-control" name="status" id="status" style="width: 408px;" data-parsley-required="true" required>
                                                <option value="">--</option>
                                                <?php foreach ($ap_status as $ap_status) : ?> 
                                                <?php if ($ap_status['id'] == $data['status']) : ?>  
                                                <option value="<?php echo $ap_status['id'] ?>" selected="selected"><?php echo $ap_status['status_code'].' - '.$ap_status['status_name'] ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $ap_status['id']?>"><?php echo $ap_status['status_code'].' - '.$ap_status['status_name'] ?></option>        
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" id="_tags">
                                            <label>Date tag as Implemented</label>
                                            <?php if ($data['date_tag'] == null): ?>
                                            <input style="width: 200px;" class="btn btn-success btn-xs" type="text" name="date_tag" id="date_tag" value="<?php echo $data['date_tag'] ?>" readonly="readonly"/>
                                            <?php else: ?>
                                            <input style="width: 200px;" class="btn btn-success btn-xs" type="text" name="date_tag" id="date_tag" value="<?php echo date('F j\, Y \ l', strtotime($data['date_tag'])) ?>" readonly="readonly"/>  
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
                                            <input type="text" id="due_date" value="<?php echo date('d-m-Y', strtotime($data['due_date'])) ?>" placeholder="dd-mm-yyyy" name="due_date" data-parsley-required="true" maxlength="10" class="form-control datepicker"/>
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>  -->
                                        </div>
                                    </div>
                                    <div class="col-md-4"> 
                                        <label>Revised Due Date</label>
                                        <div class="input-group date">
                                            <?php if ($data['date_revised'] == null): ?>   
                                            <input type="text" id="date_revised" value="<?php echo $data['date_revised'] ?>" placeholder="dd-mm-yyyy" name="date_revised" maxlength="10" class="form-control datepicker"/>
                                            <?php else: ?>
                                            <input type="text" id="date_revised" value="<?php echo date('d-m-Y', strtotime($data['date_revised'])) ?>" placeholder="dd-mm-yyyy" name="date_revised" maxlength="10" class="form-control datepicker"/>
                                            <?php endif; ?>
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->  
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="_dateimplement">
                                        <label>Date Implemented</label>
                                        <div class="input-group date">
                                            <?php if ($data['date_implemented'] == null): ?>  
                                            <input type="text" id="date_implemented" value="<?php echo $data['date_implemented'] ?>" placeholder="dd-mm-yyyy" maxlength="10" name="date_implemented" class="form-control datepicker"/>
                                            <?php else: ?>
                                            <input type="text" id="date_implemented" value="<?php echo date('d-m-Y', strtotime($data['date_implemented'])) ?>" placeholder="dd-mm-yyyy" maxlength="10" name="date_implemented" class="form-control datepicker"/> 
                                            <?php endif; ?>
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                                        </div>
                                        <div class="row-form-booking pull-right" style="margin-top: 12px;margin-right: 8px;">
                                            <button type="save" class="btn btn-success btn-sm" id="save" name="save" value="save">Save Update</button>
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
