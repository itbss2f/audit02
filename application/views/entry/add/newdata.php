<div class="breadcrumb pull-right" style="margin-right: 10px;">
    <li><i class="fa fa-home"></i>Home</li>
    <li class="active"><i class="fa fa-file"></i> Transaction</li>
    <li class="active"><i class="fa fa-plus-square"></i>Business Concern Entry</li>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <button id="refresh" title="Reload" class="btn btn-xs fa fa-repeat btn-danger pull-right" style="height: 22px;width:30px;margin-bottom: 1px;"></button>
                    <div class="btn-group pull-right" style="margin-right: 1px;margin-top: 1px;">
                        <button type="button" class="btn btn-square btn-success btn-xs"><i class="fa fa-navicon"></i></button>
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a>
                                    <button type="button" class="btn btn-success btn-xs" id="searchbccode">Add New Action Plan</button>
                                </a>
                                <a>
                                    <button type="button" class="btn btn-success btn-xs" id="searchactioncode">Add New Business Concern</button>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <h4 class="panel-title">Business Concern Form - <?php echo $this->session->userdata('sess_company_name');?></h4>
            </div>
           <div class="panel-body">
                <form action="<?php echo site_url('entry/save') ?>" onsubmit="return validate(this)" method="POST" data-parsley-validate="true" name="form-wizard" id="formsave" class="formsave" />
                    <div id="wizard">
                        <ol style="padding: 0px;">
                            <li>
                                <label> Business Concern </label> <!--Step 1-->
                            </li>
                            <li>
                                <label> Action Plan </label> <!--Step 2-->
                            </li>
                        </ol>
                        <!--begin wizard step-1-->
                        <div class="wizard-step-1">
                            <fieldset>
                                <div class="row">
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
                                            <textarea class="textarea form-control" id="business_concern" name="business_concern" placeholder="Enter Business Concern ..." rows="8" data-parsley-group="wizard-step-1" data-parsley-required="true" required></textarea>
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
                                            <select class="form-control" id="emp" name="emp" data-parsley-group="wizard-step-1" data-parsley-required="true"/>
                                            <option value="">----</option>
                                            <?php foreach ($emp as $row) : ?>
                                            <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control" name="dept" id="dept" data-parsley-group="wizard-step-1" data-parsley-required="true" required/>
                                            <option value="">----</option>
                                            <?php foreach ($dept as $row) : ?>
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
                                            <select class="form-control" id="emp2" name="emp2"/>
                                            <option value="">----</option>
                                            <?php foreach ($emp as $row) : ?>
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
                                            <?php foreach ($dept as $row) : ?>
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
                                            <?php foreach ($emp as $row) : ?>
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
                                            <?php foreach ($dept as $row) : ?>
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
                                            <select class="form-control" id="project_id" name="project_id" data-parsley-group="wizard-step-1" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($ap_project as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="recur" data-parsley-group="wizard-step-1" data-parsley-required="true" required readonly="readonly" disabled="disabled">
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
                                            <select class="form-control" id="assigned_audit" name="assigned_audit" data-parsley-group="wizard-step-1" data-parsley-required="true" required>
                                                <option value="">----</option>
                                                <?php foreach ($ap_users as $row) : ?>
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
                                            <select class="form-control" id="issue" name="issue" data-parsley-group="wizard-step-1" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($ap_issue as $row) : ?>
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
                                            <?php foreach ($internal_cc as $row) : ?>
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
                                            <?php foreach ($iccomponents as $row) : ?>
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
                                            <select class="form-control" id="risk1" name="risk1" data-parsley-group="wizard-step-1" data-parsley-required="true">
                                            <option value="">------</option>
                                            <?php foreach ($ap_risk as $row) : ?>
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
                                            <?php foreach ($ap_risk2 as $row) : ?>
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
                                            <?php foreach ($ap_risk3 as $row) : ?>
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
                                            <select class="form-control" id="risk_rating" name="risk_rating" data-parsley-group="wizard-step-1" data-parsley-required="true">
                                            <option value="">----</option>
                                            <?php foreach ($ap_risk_rating as $row) : ?>
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
                                    <div class="col-md-12" id="x_impact_remarks" style="display: none;">
                                        <label>Impact Computation Basis</label>
                                        <textarea class="textarea form-control ximpact_remarks" id="impact_remarks" name="impact_remarks" disabled placeholder="Enter Impact Computation ..." rows="5"></textarea>
                                    </div>
                                    <div class="col-md-12" id="x_impact_remarks2" style="display: none;">
                                        <label>Impact Computation Basis</label>
                                        <textarea class="textarea form-control ximpact_remarks2" id="impact_remarks_2" name="impact_remarks" placeholder="Enter Impact Computation ..." rows="5" value="0.00" data-parsley-group="wizard-step-1" data-parsley-required="true"></textarea>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Status / Date Tagged as implemented</legend>
                                <div class="row">
                                    <div class="col-md-6" id="b_status">
                                        <div class="form-group">
                                            <Label>Status</label>
                                            <select class="form-control" id="bc_status" name="bc_status" data-parsley-group="wizard-step-1" data-parsley-required="true">
                                            <option value="">----</option>
                                            <?php foreach ($bc_status as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['status_code'] .' - '.$row['status_name']?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
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
                                            <input type="text" class="btn btn-success btn-xs" id="due_date" name="due_date" style="font-weight: bold;" placeholder="mm-dd-yyyy" data-parsley-group="wizard-step-1" data-parsley-required="true" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date Resolved</label>
                                        <div class="input-group date" id="d_implemented1">
                                          <input type="text" class="btn btn-success btn-xs" id="date_implemented" name="date_implemented" style="font-weight: bold;" placeholder="mm-dd-yyyy" readonly="readonly">
                                        </div>
                                        <div class="input-group date datedayspicker3" id="d_implemented2" style="display:none">
                                          <input type="text" class="btn btn-success btn-xs" id="date_implementedx" name="date_implemented" style="font-weight: bold;" placeholder="mm-dd-yyyy" readonly="readonly" data-parsley-group="wizard-step-1" data-parsley-required="true">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <!-- begin wizard step-2 -->
                        <div class="wizard-step-2">
                            <fieldset>
                                <div class="row">
                                    <div class="row-form-booking pull-right">
                                        <button type="save" class="btn btn-success btn-sm" id="xsave" name="xsave" value="xsave">Save</button>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Action Plan</legend>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <!--<label style="font-size: 12px;font-weight: bold;">Date Entered</label>-->
                                            <input style="width: 200px;" class="btn btn-success btn-xs" type="hidden" id="entered_date" name="book[entered_date][0]" value="<?php echo date('F j\, Y \ l')  ?>" readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <!--Add More Fields-->
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group" id="_addInput" style="display: none">
                                            <button type="button" class="btn btn-success btn-sm" id="addInput" title="add">Add More</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="myDiv">
                                        <div class="col-md-6">
                                            <p>
                                                <textarea class="form-control" row="8" style="font-weight: bold;color: red;" id="myCodeap" name="myCodeap" readonly="readonly"/></textarea>
                                                <label for="myCodeExist"><input type="text" class="form-control" id="myCodeExist" name="myCodeExist" placeholder="Input Code here"></label>
                                                <label for="mySearchExist"><button class="btn btn-success" type="button" id="mySearchExist" name="mySearchExist" title="search">Search</button></label>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <Label>Action Code*:</label>
                                            <input class="form-control number" type="text" id="code" name="book[code][0]" value="<?php echo "FAAP".substr(md5(uniqid(mt_rand(), true)), 0, 4) ?>" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!--<label>ACtion Plan:</label>-->
                                            <textarea class="form-control" id="action_plan" name="book[action_plan][0]" placeholder="Enter Action Plan ..." rows="8"  data-parsley-required="true" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;margin-top: 10px;">Department Details / Employees Responsibles</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Person Responsible</label>
                                            <select class="form-control" id="ap_emp" name="book[ap_emp][0]" data-parsley-required="true" required/>
                                            <option value="">----</option>
                                            <?php foreach ($emp as $row) : ?>
                                            <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control" id="ap_dept" name="book[ap_dept][0]" data-parsley-required="true" required/>
                                            <option value="">----</option>
                                            <?php foreach ($dept as $row) : ?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['name'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="xx_ap_emp_2" style="display:none;">
                                        <div class="form-group">
                                            <label>Second Person Responsible</label>
                                            <select class="form-control" id="ap_emp_2" name="book[ap_emp_2][0]"/>
                                            <option value="">----</option>
                                            <?php foreach ($emp as $row) : ?>
                                            <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="xx_ap_dept2" style="display:none;">
                                        <div class="form-group">
                                            <label>Second Department</label>
                                            <select class="form-control" id="ap_dept_2" name="book[ap_dept_2][0]"/>
                                            <option value="">----</option>
                                            <?php foreach ($dept as $row) : ?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['name'] ?></option>
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
                                            <select class="form-control" id="ap_assigned_audit" name="book[ap_assigned_audit][0]" data-parsley-required="true" required>
                                                <option value="">----</option>
                                                <?php foreach ($ap_users as $row) : ?>
                                                <option value="<?php echo $row['user_id'] ?>"><?php echo $row['audit_staff'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <select class="form-control" id="ap_project_id" name="book[ap_project_id][0]" data-parsley-required="true" required>
                                            <option value="">----</option>
                                            <?php foreach ($ap_project as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Status / Date Tagged as implemented</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" id="_status">
                                            <Label>Status</label>
                                            <select class="form-control ap_status1" id="ap_status1" name="book[ap_status][0]">
                                            <option value="">----</option>
                                            <?php foreach ($ap_status as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['status_code'] .' - '.$row['status_name']?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group" id="_status2">
                                            <Label>Status</label>
                                            <select class="form-control ap_status2" id="ap_status2x" name="book[ap_status2][0]">
                                            <option value="">----</option>
                                            <?php foreach ($ap_status2 as $row) : ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['status_code'] .' - '.$row['status_name']?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Date tagged as Implemented</label>
                                            <input class="btn btn-success btn-xs" type="text" id="ap_date_tag" name="book[ap_date_tag][0]" value="" readonly="readonly"/>
                                        </div>
                                    </div>
                                </div>
                                <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;">Due Dates</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <Label>Due Date</label>
                                        <div class="input-group date datedayspicker" id="xdue_date">
                                            <input type="text" class="btn btn-success btn-xs" id="ap_due_date" name="book[ap_due_date][0]" placeholder="mm-dd-yyyy" style="font-weight: bold;" readonly="readonly">
                                        </div>
                                        <div class="input-group date datedayspicker2" id="xdue_date2" style="display:none;">
                                            <input type="text" class="btn btn-success btn-xs" id="ap_due_date2" name="book[ap_due_date][0]" disabled placeholder="mm-dd-yyyy" style="font-weight: bold;" readonly="readonly">
                                        </div>
                                        <div class="input-group date datedayspicker3" id="xdue_date3" style="display:none;">
                                            <input type="text" class="btn btn-success btn-xs" id="ap_due_date3" name="book[ap_due_date][0]" disabled placeholder="mm-dd-yyyy" style="font-weight: bold;" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date Implemented</label>
                                        <div class="input-group date" id="ap_implemented1">
                                            <input type="text" class="btn btn-success btn-xs" id="ap_date_implemented" name="book[ap_date_implemented][0]" placeholder="mm-dd-yyyy" readonly="readonly"/>
                                        </div>
                                        <div class="input-group date" id="ap_implemented2" style="display:none">
                                            <input type="text" class="btn btn-success btn-xs datedayspicker3" id="ap_date_implementedx" name="book[ap_date_implemented][0]" placeholder="mm-dd-yyyy" style="font-weight: bold;" data-parsley-required="true" readonly="readonly" />
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group hide" id="action_planTemplate">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <input style="width: 200px;" class="btn btn-success btn-xs" type="hidden" id="entered_date_x" name="entered_date" value="<?php echo date('F j\, Y \ l')  ?>" readonly="readonly"/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2" id="_type">
                                                    <Label style="font-size: 12px;font-weight: bold">Action Code:</label>
                                                    <select class="form-control number" type="text" id="code_x" name="code">
                                                    <option value="">----</option>
                                                    <option value="1">ADD</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <textarea class="form-control" id="action_plan_x" name="action_plan" placeholder="Enter Action Plan ..." rows="8"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6" id="ap_ap_emp">
                                                    <label>Person Responsible</label>
                                                    <select class="form-control" id="ap_emp_x" name="ap_emp">
                                                    <option value="">----</option>
                                                    <?php foreach ($emp as $row) : ?>
                                                    <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6" id="ap_ap_dept">
                                                    <label>Department</label>
                                                    <select class="form-control" id="ap_dept_x" name="ap_dept">
                                                    <option value="">----</option>
                                                    <?php foreach ($dept as $row) : ?>
                                                    <option value="<?php echo $row['id']?>"><?php echo $row['name'] ?></option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6" id="xxap_emp_2" style="display:none;">
                                                    <label>Second Person Responsible</label>
                                                    <select class="form-control" id="ap_emp_2_x" name="ap_emp_2" />
                                                    <option value="">----</option>
                                                    <?php foreach ($emp as $row) : ?>
                                                    <option value="<?php echo $row['user_id']?>"><?php echo $row['fullname'] ?></option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6" id="xxap_dept_2" style="display:none;">
                                                    <label>Second Department</label>
                                                    <select class="form-control" id="ap_dept_2_x" name="ap_dept_2" />
                                                    <option value="">----</option>
                                                    <?php foreach ($dept as $row) : ?>
                                                    <option value="<?php echo $row['id']?>"><?php echo $row['name'] ?></option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <legend class="pull-left width-full" style="font-size: 12px;font-weight: bold;margin-top: 10px;">Assigned Audit / Project Name</legend>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <Label>Assigned Audit</label>
                                                        <select class="form-control" id="ap_assigned_audit_x" name="ap_assigned_audit">
                                                            <option value="">----</option>
                                                            <?php foreach ($ap_users as $row) : ?>
                                                            <option value="<?php echo $row['user_id'] ?>"><?php echo $row['audit_staff'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Project Name</label>
                                                        <select class="form-control" id="ap_project_id_x" name="ap_project_id">
                                                        <option value="">----</option>
                                                        <?php foreach ($ap_project as $row) : ?>
                                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                                                        <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group" id="a_status" style="display: none">
                                                        <Label>Status</label>
                                                        <select class="form-control" id="ap_status_x" name="ap_status" disabled>
                                                        <option value="">----</option>
                                                        <?php foreach ($ap_status as $row) : ?>
                                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['status_code'] .' - '.$row['status_name']?></option>
                                                        <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" id="a_status_2" style="display: none">
                                                        <Label>Status</label>
                                                        <select class="form-control" id="ap_status_xx" name="ap_status" disabled>
                                                        <option value="">----</option>
                                                        <?php foreach ($ap_status2 as $row) : ?>
                                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['status_code'] .' - '.$row['status_name']?></option>
                                                        <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Date tagged as Implemented</label>
                                                        <input class="btn btn-success btn-xs" type="text" name="ap_date_tag" id="ap_date_tag_x" value="" readonly="readonly"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <Label>Due Date</label>
                                                        <div class="input-group date datedayspicker" id="xxdue_date1">
                                                            <input type="text" class="btn btn-success btn-xs" id="ap_due_date_x" name="ap_due_date" placeholder="mm/dd/yyyy" style="font-weight: bold;" readonly="readonly">
                                                        </div>
                                                        <div class="input-group date datedayspicker2" id="xxdue_date2" style="display:none;">
                                                            <input type="text" class="btn btn-success btn-xs" id="ap_due_date_xx2" name="ap_due_date" disabled placeholder="mm/dd/yyyy" style="font-weight: bold;" readonly="readonly">
                                                        </div>
                                                        <div class="input-group date datedayspicker3" id="xxdue_date3" style="display:none;">
                                                            <input type="text" class="btn btn-success btn-xs" id="ap_due_date_xx3" name="ap_due_date" disabled placeholder="mm/dd/yyyy" style="font-weight: bold;" readonly="readonly">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Date Implemented</label>
                                                    <div class="input-group date" id="ap_implemented1a">
                                                        <input type="text" class="btn btn-success btn-xs" id="ap_date_implemented_a" name="ap_date_implemented" disabled placeholder="mm-dd-yyyy" readonly="readonly" />
                                                    </div>
                                                    <div class="input-group date" id="ap_implemented2b" style="display:none">
                                                        <input type="text" class="btn btn-success btn-xs datedayspicker3" id="ap_date_implemented_b" name="ap_date_implemented" disabled placeholder="mm-dd-yyyy" style="font-weight: bold;" readonly="readonly" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <!-- ADD BUTTON OF ACTIOM PLAN-->
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="button" id="addButton" class="btn btn-default" title="add new action plan"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row-form-booking pull-right">
                                            <button type="save" class="btn btn-success btn-sm" id="bottomsave" name="bottomsave" value="bottomsave" style="margin-top : 12px;">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </fieldset>
                        </div>
                        <!-- end wizard step-2 -->
                    </div>
                </form>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-12 -->
</div>
<!-- end row -->

<div id="modal_searchap" title="Search Action Code"></div>
<div id="modal_searchbc" title="Search Business Concern Code"></div>

<script type="text/javascript">

$(function() {
    $('#myCodeExist').keyup(function(){
         if($('#myCodeExist').val() == '') {
            $('#_addInput').hide();
            $('#myCodeExist_2').hide();
            $('#myCodeExist_2').val("");
            
        } else {
            $('#_addInput').show();
            $('#myCodeExist_2').show();
            
        }
    });
});

//Display the Action Plan to textarea
$(function() {
        var scntDiv = $('#myDiv');
        var i = $('#myDiv p').size() + 1;

        $('#addInput').click(function() {

            $('<div class="col-md-6"><p><textarea class="form-control" rows="2" style="font-weight: bold;color: red;" id="myCodeap_' + i +'" name="myCodeap' + i +'" readonly="readonly"/></textarea><label for="myCodeExist"><input type="text" class="form-control" id="myCodeExist_' + i +'" name="myCodeExist_' + i +'" placeholder="Input Code here"></label><label for="mySearchExist"><button class="btn btn-success" type="button" id="mySearchExist_' + i +'" name="mySearchExist' + i +'" onclick="myFunction('+ i +')" title="search">Search</button></label><button class="btn btn-success" id="remInput" onclick="removeMe('+ i +')"><i class="fa fa-minus"></i></button></p></div>').appendTo(myDiv);
            i++;
            return false;
        });

    removeMe = function(id){

        if( i > 2 ) {
            $('#myCodeap_'+id).parents('p').remove();
            $('#myCodeExist_'+id).parents('p').remove();
            $('#mySearchExist_'+id).parents('p').remove();

           i--;


        }
        return false;
    }

    myFunction = function(id) {

            $('#mySearchExist_'+id).live('click',function(){
                var $myCodeExist_2 = $("#myCodeExist_2").val();
                $.ajax({
                    url: '<?php echo site_url('entry/ajaxsearchkey') ?>',
                    type: 'post',
                    data: {myCodeExist_2: $myCodeExist_2},
                    success: function(response){
                        $response = $.parseJSON(response)
                          if ($response['valid']) {
                            $('#myCodeap_2').html($response['apdetails']['action_plan']);
                        } else {
                            alert('Enter Code');
                            return false;
                        }
                    }
                });

                var $myCodeExist_3 = $("#myCodeExist_3").val();
                $.ajax({
                    url: '<?php echo site_url('entry/ajaxsearchkey_2') ?>',
                    type: 'post',
                    data: {myCodeExist_3: $myCodeExist_3},
                    success: function(response){
                        $response = $.parseJSON(response)
                          if ($response['valid']) {
                            $('#myCodeap_3').html($response['apdetails']['action_plan']);
                        } else {
                            alert('Enter Code');
                            return false;
                        }
                    }
                });


            });
        }

});

//Redirect to searchkey (controller and model)
$('#mySearchExist').click(function(){
    var $myCodeExist = $("#myCodeExist").val();
    $.ajax({
        url: '<?php echo site_url('entry/searchkey') ?>',
        type: 'post',
        data: {myCodeExist: $myCodeExist},
        success: function(response){
            $response = $.parseJSON(response)
              if ($response['valid']) {
                $('#myCodeap').html($response['apdetails']['action_plan']);
            } else {
                alert('Enter Code');
            }
        }
    });
});

/*$(document).ready(function() {
    var max_fields      = 3; //maximum input boxes allowed
    var wrapper         = $("#input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID


    var x = 0; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment

            var html = ('<div class="row"><div class="col-md-2"><div class="form-control" type="text" style="font-weight: bold;color: red" id="codeap" name="codeap" readonly="readonly"/></div><div class="col-md-2"><input class="form-control" type="text" id="codeexist" name="codeexist" placeholder="Input Code here"></div><div class="col-md-2"><button class="form-control btn btn-success" type="button" id="searchexist" name="searchexist" title="search">Search</button></div><div></div><button class="btn btn-success remove_field"><i class="fa fa-minus"></i></button></div></div>');

            $(wrapper).append(html);

        } else {
          alert('Only 3 max');
        }

    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});*/


$(function() {

    $('#modal_searchbc').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 800,
       show: "blind",
       hide: "explode",
       height: 400,
       modal: true,
       resizable: false
    });

    $('#searchbccode').click(function() {
        $.ajax({
          url: "<?php echo site_url('entry/addtionalap') ?>",
          type: "post",
          data: {},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_searchbc").html($response['addtionalap']).dialog('open');
              }
           });
    });
    return false;

});

$(function() {

    $('#modal_searchap').dialog({
       autoOpen: false,
       closeOnEscape: true,
       draggable: true,
       width: 800,
       show: "blind",
       hide: "explode",
       height: 400,
       modal: true,
       resizable: false
    });

    $('#searchactioncode').click(function() {
        $.ajax({
          url: "<?php echo site_url('entry/addtionalbc') ?>",
          type: "post",
          data: {},
          success:function(response) {
             $response = $.parseJSON(response);
              $("#modal_searchap").html($response['addtionalbc']).dialog('open');
              }
           });
        });
        return false;
});

//filtering of numbers in action plan code:
$('input[name="ap_impact_value"]').keyup(function(e){
  if (/\D/g(this.value)){
    this.value = this.value.replace(/[^0-9\.]/g, '');
  }
});

$("#impact_value").maskMoney();
$(".ap_impact_value").maskMoney();
//$("#ap_impact_value_x1").maskMoney();


//START END OF ACTION PLAN TEMPLATE
// Add button click handler
$(document).ready(function()  {
    var actionIndex = 0;
    $("#addButton").click(function() {
        if (actionIndex == 1) {
            alert('Action Plan number 3');
        }   else if (actionIndex == 2) {
            }   else if (actionIndex == 3) {
                    alert('Action Plan number 5');
                }   else if (actionIndex == 4) {
                        alert("Only 5 Action Plans allow");
                        return false;
                    }
          
                        actionIndex++;

                        var $template = $('#action_planTemplate'),
                        $clone    = $template
                                    .clone()
                                    .removeClass('hide')
                                    .removeAttr('id')
                                    .attr('actionIndex', actionIndex)
                                    .insertBefore($template);

                                    //Three Types of Datepicker
                                    $(function(){
                                        $('.datedayspicker').datepicker({
                                            dateFormat: 'mm-dd-yyyy',
                                            //startDate: '-0m'
                                        }).on('changeDate', function(ev){
                                            //$('#sDate1').text($('.datedayspicker').data('date'));
                                            $('.datedayspicker').datepicker('hide');
                                        });

                                        $('.datedayspicker2').datepicker({
                                            dateFormat: 'mm-dd-yyyy',
                                            startDate: '-0m'
                                        }).on('changeDate', function(ev){
                                            $('#sDate1').text($('.datedayspicker2').data('date'));
                                            $('.datedayspicker2').datepicker('hide');
                                        });

                                        $('.datedayspicker3').datepicker({
                                            dateFormat: 'mm-dd-yyyy',
                                            endDate: '-0m'
                                        }).on('changeDate', function(ev){
                                            $('#sDate1').text($('.datedayspicker3').data('date'));
                                            $('.datedayspicker3').datepicker('hide');
                                        });

                                    });
                                    //end
                                    //TAB 2 VALIDATION OF ACTION PLAN.
                                    $('#_type1').live('click',function(){
                                        var $id = $("#code_x1").val();
                                        var $idbc = $("#bc_status").val();
                                        $.ajax({
                                            url: "",
                                            type: 'post',
                                            data: {id: $id, idbc: $idbc},
                                            success: function(response) { 
                                                if ($idbc != 10) {
                                                    $("#a_status1").show(); 
                                                    $("#ap_status_x1").attr('data-parsley-required', 'true');
                                                    $("#a_status_21").hide();  
                                                    $("#ap_status_xx1").attr('data-parsley-required', 'false');
                                                    $("#ap_status_x1").prop('disabled',false); 
                                                }
                                                else {
                                                    $("#a_status1").hide(); 
                                                    $("#ap_status_x1").attr('data-parsley-required', 'false');
                                                    $("#a_status_21").show();  
                                                    $("#ap_status_xx1").attr('data-parsley-required', 'true');
                                                    $("#ap_status_xx1").prop('disabled',false);

                                                }
                                                if ($id != 0) {
                                                    $("#action_plan_x1").attr('data-parsley-required', 'true');
                                                    $("#ap_emp_x1").attr('data-parsley-required', 'true');
                                                    $("#ap_dept_x1").attr('data-parsley-required', 'true');
                                                    $("#ap_assigned_audit1").attr('data-parsley-required', 'true');
                                                    $("#ap_project_id_x1").attr('data-parsley-required', 'true');

                                                } 
                                                else  {
                                                    $("#action_plan_x1").attr('data-parsley-required', 'false');
                                                    $("#ap_emp_x1").attr('data-parsley-required', 'false');
                                                    $("#ap_dept_x1").attr('data-parsley-required', 'false');
                                                    $("#ap_assigned_audit1").attr('data-parsley-required', 'false');
                                                    $("#ap_project_id_x1").attr('data-parsley-required', 'false');
                                                    $("#ap_status_x1").val(''); //if not selected
                                                    $("#ap_status_xx1").val(''); //if not selected
                                                    $("#ap_status_x1").prop('disabled',true);
                                                    $("#ap_status_xx1").prop('disabled',true);
                                                    $("#ap_status_x1").attr('data-parsley-required', 'false'); //if not selected
                                                    $("#ap_status_xx1").attr('data-parsley-required', 'false'); //if not selected
                                                    $("#ap_date_tag_x1").val(""); // if not selected
                                                    $("#ap_date_implemented_a1").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_date_implemented_b1").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_xx31").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_xx21").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_x1").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_date_implemented_a1").prop('disabled',true);
                                                    $("#ap_date_implemented_b1").prop('disabled',true);
                                                }
                                            }
                                        })
                                    });
                                    //TAB 3 VALIDATION OF ACTION PLAN.
                                    $('#_type2').live('click',function(){
                                        var $id2 = $("#code_x2").val();
                                        var $idbc2 = $("#bc_status").val();
                                        $.ajax({
                                            url: "",
                                            type: 'post',
                                            data: {id2: $id2, idbc2: $idbc2},
                                            success: function(response) { 
                                                if ($idbc2 != 10) {
                                                    $("#a_status2").show(); 
                                                    $("#ap_status_x2").attr('data-parsley-required', 'true');
                                                    $("#a_status_22").hide();  
                                                    $("#ap_status_xx2").attr('data-parsley-required', 'false'); 
                                                    $("#ap_status_x2").prop('disabled',false); 
                                                }
                                                else {
                                                    $("#a_status2").hide(); 
                                                    $("#ap_status_x2").attr('data-parsley-required', 'false');
                                                    $("#a_status_22").show();  
                                                    $("#ap_status_xx2").attr('data-parsley-required', 'true');
                                                    $("#ap_status_xx2").prop('disabled',false);

                                                }
                                                if ($id2 != 0) {
                                                    $("#action_plan_x2").attr('data-parsley-required', 'true');
                                                    $("#ap_emp_x2").attr('data-parsley-required', 'true');
                                                    $("#ap_dept_x2").attr('data-parsley-required', 'true');
                                                    $("#ap_assigned_audit2").attr('data-parsley-required', 'true');
                                                    $("#ap_project_id_x2").attr('data-parsley-required', 'true');
                                                } 
                                                else  {
                                                    $("#action_plan_x2").attr('data-parsley-required', 'false');
                                                    $("#ap_emp_x2").attr('data-parsley-required', 'false');
                                                    $("#ap_dept_x2").attr('data-parsley-required', 'false');
                                                    $("#ap_assigned_audit2").attr('data-parsley-required', 'false');
                                                    $("#ap_project_id_x2").attr('data-parsley-required', 'false');
                                                    $("#ap_status_x2").val(''); //if not selected
                                                    $("#ap_status_xx2").val(''); //if not selected
                                                    $("#ap_status_x2").prop('disabled',true);
                                                    $("#ap_status_xx2").prop('disabled',true);
                                                    $("#ap_status_x2").attr('data-parsley-required', 'false'); //if not selected
                                                    $("#ap_status_xx2").attr('data-parsley-required', 'false'); //if not selected
                                                    $("#ap_date_tag_x2").val(""); // if not selected
                                                    $("#ap_date_implemented_a2").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_date_implemented_b2").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_xx32").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_xx22").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_x2").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_date_implemented_a2").prop('disabled',true);
                                                    $("#ap_date_implemented_b2").prop('disabled',true);
                                                }
                                            }
                                        })
                                    });
                                    //TAB 4 VALIDATION OF ACTION PLAN.
                                    $('#_type3').live('click',function(){
                                        var $id3 = $("#code_x3").val();
                                        var $idbc3 = $("#bc_status").val();
                                        $.ajax({
                                            url: "",
                                            type: 'post',
                                            data: {id3: $id3, idbc3: $idbc3},
                                            success: function(response) { 
                                                if ($idbc3 != 10) {
                                                    $("#a_status3").show(); 
                                                    $("#ap_status_x3").attr('data-parsley-required', 'true');
                                                    $("#a_status_23").hide();  
                                                    $("#ap_status_xx3").attr('data-parsley-required', 'false'); 
                                                    $("#ap_status_x3").prop('disabled',false); 
                                                }
                                                else {
                                                    $("#a_status3").hide(); 
                                                    $("#ap_status_x3").attr('data-parsley-required', 'false');
                                                    $("#a_status_23").show();  
                                                    $("#ap_status_xx3").attr('data-parsley-required', 'true');
                                                    $("#ap_status_xx3").prop('disabled',false);

                                                }
                                                if ($id3 != 0) {
                                                    $("#action_plan_x3").attr('data-parsley-required', 'true');
                                                    $("#ap_emp_x3").attr('data-parsley-required', 'true');
                                                    $("#ap_dept_x3").attr('data-parsley-required', 'true');
                                                    $("#ap_assigned_audit3").attr('data-parsley-required', 'true');
                                                    $("#ap_project_id_x3").attr('data-parsley-required', 'true');
                                                } 
                                                else  {
                                                    $("#action_plan_x3").attr('data-parsley-required', 'false');
                                                    $("#ap_emp_x3").attr('data-parsley-required', 'false');
                                                    $("#ap_dept_x3").attr('data-parsley-required', 'false');
                                                    $("#ap_assigned_audit3").attr('data-parsley-required', 'false');
                                                    $("#ap_project_id_x3").attr('data-parsley-required', 'false');
                                                    $("#ap_status_x3").val(''); //if not selected
                                                    $("#ap_status_xx3").val(''); //if not selected
                                                    $("#ap_status_x3").prop('disabled',true);
                                                    $("#ap_status_xx3").prop('disabled',true);
                                                    $("#ap_status_x3").attr('data-parsley-required', 'false'); //if not selected
                                                    $("#ap_status_xx3").attr('data-parsley-required', 'false'); //if not selected
                                                    $("#ap_date_tag_x3").val(""); // if not selected
                                                    $("#ap_date_implemented_a3").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_date_implemented_b3").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_xx33").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_xx23").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_x3").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_date_implemented_a3").prop('disabled',true);
                                                    $("#ap_date_implemented_b3").prop('disabled',true);
                                                }
                                            }
                                        })
                                    });
                                    //TAB 5 VALIDATION OF ACTION PLAN.
                                    $('#_type4').live('click',function(){
                                        var $id4 = $("#code_x4").val();
                                        var $idbc4 = $("#bc_status").val();
                                        $.ajax({
                                            url: "",
                                            type: 'post',
                                            data: {id4: $id4, idbc4: $idbc4},
                                            success: function(response) { 
                                                if ($idbc4 != 10) {
                                                    $("#a_status4").show(); 
                                                    $("#ap_status_x4").attr('data-parsley-required', 'true');
                                                    $("#a_status_24").hide();  
                                                    $("#ap_status_xx4").attr('data-parsley-required', 'false');
                                                    $("#ap_status_x4").prop('disabled',false);  
                                                }
                                                else {
                                                    $("#a_status4").hide(); 
                                                    $("#ap_status_x4").attr('data-parsley-required', 'false');
                                                    $("#a_status_24").show();  
                                                    $("#ap_status_xx4").attr('data-parsley-required', 'true');
                                                    $("#ap_status_xx4").prop('disabled',false); 

                                                }
                                                if ($id4 != 0) {
                                                    $("#action_plan_x4").attr('data-parsley-required', 'true');
                                                    $("#ap_emp_x4").attr('data-parsley-required', 'true');
                                                    $("#ap_dept_x4").attr('data-parsley-required', 'true');
                                                    $("#ap_assigned_audit4").attr('data-parsley-required', 'true');
                                                    $("#ap_project_id_x4").attr('data-parsley-required', 'true');
                                                } 
                                                else  {
                                                    $("#action_plan_x4").attr('data-parsley-required', 'false');
                                                    $("#ap_emp_x4").attr('data-parsley-required', 'false');
                                                    $("#ap_dept_x4").attr('data-parsley-required', 'false');
                                                    $("#ap_assigned_audit4").attr('data-parsley-required', 'false');
                                                    $("#ap_project_id_x4").attr('data-parsley-required', 'false');
                                                    $("#ap_status_x4").val(''); //if not selected
                                                    $("#ap_status_xx4").val(''); //if not selected
                                                    $("#ap_status_x4").prop('disabled',true);
                                                    $("#ap_status_xx4").prop('disabled',true);
                                                    $("#ap_status_x4").attr('data-parsley-required', 'false'); //if not selected
                                                    $("#ap_status_xx4").attr('data-parsley-required', 'false'); //if not selected
                                                    $("#ap_date_tag_x4").val(""); // if not selected
                                                    $("#ap_date_implemented_a4").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_date_implemented_b4").attr('data-parsley-required', 'false');// if not selected
                                                     $("#ap_due_date_xx34").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_xx24").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_due_date_x4").attr('data-parsley-required', 'false');// if not selected
                                                    $("#ap_date_implemented_a4").prop('disabled',true);
                                                    $("#ap_date_implemented_b4").prop('disabled',true);
                                                }
                                            }
                                        })
                                    });

                                    //for business concern STATUS validation:
                                    $("#b_status").change(function(){
                                        var $id = $("#bc_status").val();
                                        $.ajax({
                                            url: "<?php echo site_url('entry/ajaxstatus')?>",
                                            type: 'post',
                                            data: {id: $id},
                                            success: function(response) {
                                                if ($id != 10) {
                                                    $("#ap_implemented1a1").show(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b1").hide(); // tab2 div status of (I)
                                                    $("#ap_implemented1a2").show(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b2").hide(); // tab2 div status of (I)
                                                    $("#ap_implemented1a3").show(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b3").hide(); // tab2 div status of (I)
                                                    $("#ap_implemented1a4").show(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b4").hide(); // tab2 div status of (I)
                                                    $("#ap_date_implemented_a1").attr('disabled', 'true'); // tab2 form of (D,NY,W/L)
                                                    $("#ap_date_implemented_b1").attr('data-parsley-required', 'false');// tab2 form (I)
                                                    $("#ap_status_x1").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                    $("#ap_status_xx1").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                    $("#ap_status_x2").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                    $("#ap_status_xx2").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                }  
                                                else {
                                                    $("#ap_implemented1a1").hide();  //tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b1").show();  // tab2 div status of (I)
                                                    $("#ap_implemented1a2").hide();  //tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b2").show();  // tab2 div status of (I)
                                                    $("#ap_implemented1a3").hide();  //tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b3").show();  // tab2 div status of (I)
                                                    $("#ap_implemented1a4").hide();  //tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b4").show();  // tab2 div status of (I)
                                                    $("#ap_date_implemented_a1").attr('disabled', 'false'); // tab2 form of (D,NY,W/L)
                                                    $("#ap_date_implemented_b1").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                    $("#ap_status_x1").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                    $("#ap_status_xx1").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                    $("#ap_status_x2").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                    $("#ap_status_xx2").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                }
                                            }
                                        })
                                    });
                                    
                                    // For Action Plan STATUS validation in due date (DUE,NY,W/L)(TAB2):
                                    $('#a_status1').live('click',function(){
                                        var $id1 = $("#ap_status_x1").val(); //(TAB2)
                                        $.ajax({
                                        url: "",
                                        type: 'post',
                                        data: {id1: $id1},
                                            success: function(response) {
                                                    if ($id1 == "" || $id1 == 2) {
                                                        $("#xxdue_date11").show();
                                                        $("#xxdue_date21").hide();
                                                        $("#xxdue_date31").hide();
                                                        $("#ap_due_date_xx31").prop('disabled',true)
                                                        $("#ap_due_date_xx31").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx21").prop('disabled',true)
                                                        $("#ap_due_date_xx21").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_x1").prop("disabled", false);
                                                        $("#ap_due_date_x1").attr('data-parsley-required', 'true');
                                                    }   
                                                    else if ($id1 == 4) {
                                                        $("#xxdue_date21").show();
                                                        $("#xxdue_date31").hide();
                                                        $("#xxdue_date11").hide();
                                                        $("#ap_due_date_x1").prop("disabled", true)
                                                        $("#ap_due_date_x1").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx21").prop('disabled',false);
                                                        $("#ap_due_date_xx21").attr('data-parsley-required', 'true');
                                                        $("#ap_due_date_xx31").prop('disabled',true)
                                                        $("#ap_due_date_xx31").attr('data-parsley-required', 'false');
                                                    }
                                                    else  {
                                                        $("#xxdue_date31").show();
                                                        $("#xxdue_date11").hide();
                                                        $("#xxdue_date21").hide();
                                                        $("#ap_due_date_xx31").prop('disabled',false);
                                                        $("#ap_due_date_xx31").attr('data-parsley-required', 'true');
                                                        $("#ap_due_date_x1").prop("disabled", true)
                                                        $("#ap_due_date_x1").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx21").prop("disabled", true)
                                                        $("#ap_due_date_xx21").attr('data-parsley-required', 'false');
                                                    }
                                            }
                                        })
                                    });
                                    
                                    // For Action Plan STATUS validation in due date (DUE,NY,W/L)(TAB3):
                                    $('#a_status2').live('click',function(){
                                        var $id2 = $("#ap_status_x2").val(); //(TAB3)
                                        $.ajax({
                                        url: "",
                                        type: 'post',
                                        data: {id2: $id2},
                                            success: function(response) {
                                                    if ($id2 == "" || $id2 == 2) {
                                                        $("#xxdue_date12").show();
                                                        $("#xxdue_date22").hide();
                                                        $("#xxdue_date32").hide();
                                                        $("#ap_due_date_xx32").prop('disabled',true)
                                                        $("#ap_due_date_xx32").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx22").prop('disabled',true)
                                                        $("#ap_due_date_xx22").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_x2").prop("disabled", false);
                                                        $("#ap_due_date_x2").attr('data-parsley-required', 'true');
                                                    }   
                                                    else if ($id2 == 4) {
                                                        $("#xxdue_date22").show();
                                                        $("#xxdue_date32").hide();
                                                        $("#xxdue_date12").hide();
                                                        $("#ap_due_date_x2").prop("disabled", true)
                                                        $("#ap_due_date_x2").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx22").prop('disabled',false);
                                                        $("#ap_due_date_xx22").attr('data-parsley-required', 'true');
                                                        $("#ap_due_date_xx32").prop('disabled',true)
                                                        $("#ap_due_date_xx32").attr('data-parsley-required', 'false');
                                                    }
                                                    else  {
                                                        $("#xxdue_date32").show();
                                                        $("#xxdue_date12").hide();
                                                        $("#xxdue_date22").hide();
                                                        $("#ap_due_date_xx32").prop('disabled',false);
                                                        $("#ap_due_date_xx32").attr('data-parsley-required', 'true');
                                                        $("#ap_due_date_x2").prop("disabled", true)
                                                        $("#ap_due_date_x2").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx22").prop("disabled", true)
                                                        $("#ap_due_date_xx22").attr('data-parsley-required', 'false');
                                                    }
                                            }
                                        })
                                    });

                                    // For Action Plan STATUS validation in due date (DUE,NY,W/L)(TAB4):
                                    $('#a_status3').live('click',function(){
                                        var $id3 = $("#ap_status_x3").val(); //(TAB4)
                                        $.ajax({
                                        url: "",
                                        type: 'post',
                                        data: {id3: $id3},
                                            success: function(response) {
                                                    if ($id3 == "" || $id3 == 2) {
                                                        $("#xxdue_date13").show();
                                                        $("#xxdue_date23").hide();
                                                        $("#xxdue_date33").hide();
                                                        $("#ap_due_date_xx33").prop('disabled',true)
                                                        $("#ap_due_date_xx33").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx23").prop('disabled',true)
                                                        $("#ap_due_date_xx23").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_x3").prop("disabled", false);
                                                        $("#ap_due_date_x3").attr('data-parsley-required', 'true');
                                                    }   
                                                    else if ($id3 == 4) {
                                                        $("#xxdue_date23").show();
                                                        $("#xxdue_date33").hide();
                                                        $("#xxdue_date13").hide();
                                                        $("#ap_due_date_x3").prop("disabled", true)
                                                        $("#ap_due_date_x3").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx23").prop('disabled',false);
                                                        $("#ap_due_date_xx23").attr('data-parsley-required', 'true');
                                                        $("#ap_due_date_xx33").prop('disabled',true)
                                                        $("#ap_due_date_xx33").attr('data-parsley-required', 'false');
                                                    }
                                                    else  {
                                                        $("#xxdue_date33").show();
                                                        $("#xxdue_date13").hide();
                                                        $("#xxdue_date23").hide();
                                                        $("#ap_due_date_xx33").prop('disabled',false);
                                                        $("#ap_due_date_xx33").attr('data-parsley-required', 'true');
                                                        $("#ap_due_date_x3").prop("disabled", true)
                                                        $("#ap_due_date_x3").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx23").prop("disabled", true)
                                                        $("#ap_due_date_xx23").attr('data-parsley-required', 'false');
                                                    }
                                            }
                                        })
                                    });
                                    
                                    // For Action Plan STATUS validation in due date (DUE,NY,W/L)(TAB5):
                                    $('#a_status4').live('click',function(){
                                        var $id4 = $("#ap_status_x4").val(); //(TAB5)
                                        $.ajax({
                                        url: "",
                                        type: 'post',
                                        data: {id4: $id4},
                                            success: function(response) {
                                                    if ($id4 == "" || $id4 == 2) {
                                                        $("#xxdue_date14").show();
                                                        $("#xxdue_date24").hide();
                                                        $("#xxdue_date34").hide();
                                                        $("#ap_due_date_xx34").prop('disabled',true)
                                                        $("#ap_due_date_xx34").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx24").prop('disabled',true)
                                                        $("#ap_due_date_xx24").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_x4").prop("disabled", false);
                                                        $("#ap_due_date_x4").attr('data-parsley-required', 'true');
                                                    }   
                                                    else if ($id4 == 4) {
                                                        $("#xxdue_date24").show();
                                                        $("#xxdue_date34").hide();
                                                        $("#xxdue_date14").hide();
                                                        $("#ap_due_date_x4").prop("disabled", true)
                                                        $("#ap_due_date_x4").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx24").prop('disabled',false);
                                                        $("#ap_due_date_xx24").attr('data-parsley-required', 'true');
                                                        $("#ap_due_date_xx34").prop('disabled',true)
                                                        $("#ap_due_date_xx34").attr('data-parsley-required', 'false');
                                                    }
                                                    else  {
                                                        $("#xxdue_date34").show();
                                                        $("#xxdue_date14").hide();
                                                        $("#xxdue_date24").hide();
                                                        $("#ap_due_date_xx34").prop('disabled',false);
                                                        $("#ap_due_date_xx34").attr('data-parsley-required', 'true');
                                                        $("#ap_due_date_x4").prop("disabled", true)
                                                        $("#ap_due_date_x4").attr('data-parsley-required', 'false');
                                                        $("#ap_due_date_xx24").prop("disabled", true)
                                                        $("#ap_due_date_xx24").attr('data-parsley-required', 'false');
                                                    }
                                            }
                                        })
                                    });

                                    // For Action Plan STATUS validation (DUE,NY,W/L)(TAB2):
                                    $('#a_status1').live('click',function(){
                                        var $id = $("#ap_status_x1").val(); //(TAB2)
                                        $.ajax({
                                        url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
                                        type: 'post',
                                        data: {id: $id},
                                            success: function(response) {
                                                    if ($id != 2) {
                                                        $("#ap_date_tag_x1").val(""); // tab2 no value of date tag
                                                        $("#ap_implemented1a1").show(); // tab2 div status of (D,NY,W/L)
                                                        $("#ap_implemented2b1").hide(); // tab2 div status of (I)
                                                        $("#ap_date_implemented_a1").attr('disabled', 'true'); // tab2 form of (D,NY,W/L)
                                                        $("#ap_date_implemented_b1").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                        $("#ap_date_implemented_b1").val("");
                                                   
                                                    }   
                                                    else {
                                                        $("#ap_date_tag_x1").val('<?php echo date('F j\, Y \ l') ?>'); // tab2 with value of date tag 
                                                        $("#ap_implemented1a1").hide(); // tab2 div status of (D,NY,W/L)
                                                        $("#ap_implemented2b1").show(); // tab2 div status of (I)
                                                        $("#ap_date_implemented_a1").attr('disabled', 'false'); // tab2 form of (D,NY,W/L)
                                                        $("#ap_date_implemented_b1").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                        $("#ap_date_implemented_b1").prop('disabled',false) // can choose dates
                                                    }
                                            }
                                        })
                                    });
                                    // For Action Plan STATUS validation (DUE,NY,W/L)(TAB3):
                                    $('#a_status2').live('click',function(){
                                        var $id = $("#ap_status_x2").val(); //(TAB3)
                                        $.ajax({
                                        url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
                                        type: 'post',
                                        data: {id: $id},
                                            success: function(response) {
                                                    if ($id != 2) {
                                                        $("#ap_date_tag_x2").val(""); // tab2 no value of date tag
                                                        $("#ap_implemented1a2").show(); // tab2 div status of (D,NY,W/L)
                                                        $("#ap_implemented2b2").hide(); // tab2 div status of (I)
                                                        $("#ap_date_implemented_a2").attr('disabled', 'true'); // tab2 form of (D,NY,W/L)
                                                        $("#ap_date_implemented_b2").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                        $("#ap_date_implemented_b2").val("");
                                                   
                                                    } 
                                                    else {
                                                        $("#ap_date_tag_x2").val('<?php echo date('F j\, Y \ l') ?>'); // tab2 with value of date tag 
                                                        $("#ap_implemented1a2").hide(); // tab2 div status of (D,NY,W/L)
                                                        $("#ap_implemented2b2").show(); // tab2 div status of (I)
                                                        $("#ap_date_implemented_a2").attr('disabled', 'false'); // tab2 form of (D,NY,W/L)
                                                        $("#ap_date_implemented_b2").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                        $("#ap_date_implemented_b2").prop('disabled',false) // can choose dates
                                                    }
                                            }
                                        })
                                    });

                                    // For Action Plan STATUS validation (DUE,NY,W/L)(TAB4):
                                    $('#a_status3').live('click',function(){
                                        var $id = $("#ap_status_x3").val(); //(TAB4)
                                        $.ajax({
                                        url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
                                        type: 'post',
                                        data: {id: $id},
                                            success: function(response) {
                                                    if ($id != 2) {
                                                        $("#ap_date_tag_x3").val(""); // tab2 no value of date tag
                                                        $("#ap_implemented1a3").show(); // tab2 div status of (D,NY,W/L)
                                                        $("#ap_implemented2b3").hide(); // tab2 div status of (I)
                                                        $("#ap_date_implemented_a3").attr('disabled', 'true'); // tab2 form of (D,NY,W/L)
                                                        $("#ap_date_implemented_b3").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                        $("#ap_date_implemented_b3").val("");
                                                   
                                                    } 
                                                    else {
                                                        $("#ap_date_tag_x3").val('<?php echo date('F j\, Y \ l') ?>'); // tab2 with value of date tag 
                                                        $("#ap_implemented1a3").hide(); // tab2 div status of (D,NY,W/L)
                                                        $("#ap_implemented2b3").show(); // tab2 div status of (I)
                                                        $("#ap_date_implemented_a3").attr('disabled', 'false'); // tab2 form of (D,NY,W/L)
                                                        $("#ap_date_implemented_b3").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                        $("#ap_date_implemented_b3").prop('disabled',false) // can choose dates
                                                    }
                                            }
                                        })
                                    });

                                    // For Action Plan STATUS validation (DUE,NY,W/L)(TAB5):
                                    $('#a_status4').live('click',function(){
                                        var $id = $("#ap_status_x4").val(); //(TAB5)
                                        $.ajax({
                                        url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
                                        type: 'post',
                                        data: {id: $id},
                                            success: function(response) {
                                                    if ($id != 2) {
                                                        $("#ap_date_tag_x4").val(""); // tab2 no value of date tag
                                                        $("#ap_implemented1a4").show(); // tab2 div status of (D,NY,W/L)
                                                        $("#ap_implemented2b4").hide(); // tab2 div status of (I)
                                                        $("#ap_date_implemented_a4").attr('disabled', 'true'); // tab2 form of (D,NY,W/L)
                                                        $("#ap_date_implemented_b4").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                        $("#ap_date_implemented_b4").val("");
                                                   
                                                    } else {
                                                        $("#ap_date_tag_x4").val('<?php echo date('F j\, Y \ l') ?>'); // tab2 with value of date tag 
                                                        $("#ap_implemented1a4").hide(); // tab2 div status of (D,NY,W/L)
                                                        $("#ap_implemented2b4").show(); // tab2 div status of (I)
                                                        $("#ap_date_implemented_a4").attr('disabled', 'false'); // tab2 form of (D,NY,W/L)
                                                        $("#ap_date_implemented_b4").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                        $("#ap_date_implemented_b4").prop('disabled',false) // can choose dates
                                                    }
                                            }
                                        })
                                    });

                                    //For Action Plan STATUS validation (Implemented)(TAB2):
                                    $('#a_status_21').live('click',function(){
                                        var $id = $("#ap_status_xx1").val(); //(TAB2)
                                        $.ajax({
                                        url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
                                        type: 'post',
                                        data: {id: $id},
                                            success: function(response) {
                                                if ($id != 2) {
                                                    $("#ap_date_tag_x1").val(''); // tab2 with value of date tag 
                                                    $("#ap_implemented1a1").show(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b1").hide(); // tab2 div status of (I)
                                                    $("#ap_date_implemented_a1").attr('disabled', 'true'); // tab2 form of (D,NY,W/L)
                                                    $("#ap_date_implemented_b1").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                    $("#ap_date_implemented_b1").val("");
                                                }
                                                else {
                                                    $("#ap_date_tag_x1").val('<?php echo date('F j\, Y \ l') ?>'); // tab2 with value of date tag 
                                                    $("#ap_implemented1a1").hide(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b1").show(); // tab2 div status of (I)
                                                    $("#ap_date_implemented_a1").attr('disabled', 'false'); // tab2 form of (D,NY,W/L)
                                                    $("#ap_date_implemented_b1").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                    $("#ap_date_implemented_b1").prop('disabled',false) // can choose dates
                                                }
                                            }
                                        })
                                    });

                                    //For Action Plan STATUS validation (Implemented)(TAB3):
                                    $('#a_status_22').live('click',function(){
                                        var $id = $("#ap_status_xx2").val(); //(TAB3)
                                        $.ajax({
                                        url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
                                        type: 'post',
                                        data: {id: $id},
                                            success: function(response) {
                                                if ($id != 2) {
                                                    $("#ap_date_tag_x2").val(''); // tab2 with value of date tag 
                                                    $("#ap_implemented1a2").show(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b2").hide(); // tab2 div status of (I)
                                                    $("#ap_date_implemented_a2").attr('disabled', 'true'); // tab2 form of (D,NY,W/L)
                                                    $("#ap_date_implemented_b2").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                    $("#ap_date_implemented_b2").val("");
                                                }
                                                else {
                                                    $("#ap_date_tag_x2").val('<?php echo date('F j\, Y \ l') ?>'); // tab2 with value of date tag 
                                                    $("#ap_implemented1a2").hide(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b2").show(); // tab2 div status of (I)
                                                    $("#ap_date_implemented_a2").attr('disabled', 'false'); // tab2 form of (D,NY,W/L)
                                                    $("#ap_date_implemented_b2").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                    $("#ap_date_implemented_b2").prop('disabled',false) // can choose dates
                                                }
                                            }
                                        })
                                    });

                                    //For Action Plan STATUS validation (Implemented)(TAB4):
                                    $('#a_status_23').live('click',function(){
                                        var $id = $("#ap_status_xx3").val(); //(TAB4)
                                        $.ajax({
                                        url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
                                        type: 'post',
                                        data: {id: $id},
                                            success: function(response) {
                                                if ($id != 2) {
                                                    $("#ap_date_tag_x3").val(''); // tab2 with value of date tag 
                                                    $("#ap_implemented1a3").show(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b3").hide(); // tab2 div status of (I)
                                                    $("#ap_date_implemented_a3").attr('disabled', 'true'); // tab2 form of (D,NY,W/L)
                                                    $("#ap_date_implemented_b3").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                    $("#ap_date_implemented_b3").val("");
                                                }
                                                else {
                                                    $("#ap_date_tag_x3").val('<?php echo date('F j\, Y \ l') ?>'); // tab2 with value of date tag 
                                                    $("#ap_implemented1a3").hide(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b3").show(); // tab2 div status of (I)
                                                    $("#ap_date_implemented_a3").attr('disabled', 'false'); // tab2 form of (D,NY,W/L)
                                                    $("#ap_date_implemented_b3").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                    $("#ap_date_implemented_b3").prop('disabled',false) // can choose dates
                                                }
                                            }
                                        })
                                    });

                                    //For Action Plan STATUS validation (Implemented)(TAB5):
                                    $('#a_status_24').live('click',function(){
                                        var $id = $("#ap_status_xx4").val(); //(TAB5)
                                        $.ajax({
                                        url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
                                        type: 'post',
                                        data: {id: $id},
                                            success: function(response) {
                                                if ($id != 2) {
                                                    $("#ap_date_tag_x4").val(''); // tab2 with value of date tag 
                                                    $("#ap_implemented1a4").show(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b4").hide(); // tab2 div status of (I)
                                                    $("#ap_date_implemented_a4").attr('disabled', 'true'); // tab2 form of (D,NY,W/L)
                                                    $("#ap_date_implemented_b4").attr('data-parsley-required', 'false'); // tab2 form (I)
                                                    $("#ap_date_implemented_b4").val("");
                                                }
                                                else {
                                                    $("#ap_date_tag_x4").val('<?php echo date('F j\, Y \ l') ?>'); // tab2 with value of date tag 
                                                    $("#ap_implemented1a4").hide(); // tab2 div status of (D,NY,W/L)
                                                    $("#ap_implemented2b4").show(); // tab2 div status of (I)
                                                    $("#ap_date_implemented_a4").attr('disabled', 'false'); // tab2 form of (D,NY,W/L)
                                                    $("#ap_date_implemented_b4").attr('data-parsley-required', 'true'); // tab2 form (I)
                                                    $("#ap_date_implemented_b4").prop('disabled',false) // can choose dates
                                                }
                                            }
                                        })
                                    });
                                    //Show and hide of Person and Dept in Action Plan TAB1
                                    $(function() {
                                        $('#ap_ap_emp1').live('click',function(){
                                             if($('#ap_emp_x1').val() == '') {
                                                $('#xxap_emp_21').hide();
                                                $("#ap_emp_2_x1").val("");
                                            } else {
                                                $('#xxap_emp_21').show();
                                            }
                                        });
                                        $('#ap_emp_2_x1').live('click',function(){
                                            if($(this).val()== "")  {
                                            $("#xxap_dept_21").hide();
                                            $("#ap_dept_2_x1").val("");
                                            $("#ap_dept_2_x1").attr('data-parsley-required', 'false');
                                            }   else {
                                                $("#xxap_dept_21").show();
                                                $("#ap_dept_2_x1").attr('data-parsley-required', 'true');

                                            }
                                        });
                                    });
                                    //end
                                    //Show and hide of Person and Dept in Action Plan TAB2
                                    $(function() {
                                        $('#ap_ap_emp2').live('click',function(){
                                             if($('#ap_emp_x2').val() == '') {
                                                $('#xxap_emp_22').hide();
                                                $("#ap_emp_2_x2").val("");
                                            } else {
                                                $('#xxap_emp_22').show();
                                            }
                                        });
                                        $('#ap_emp_2_x2').live('click',function(){
                                            if($(this).val()== "")  {
                                            $("#xxap_dept_22").hide();
                                            $("#ap_dept_2_x2").val("");
                                            $("#ap_dept_2_x2").attr('data-parsley-required', 'false');
                                            }   else {
                                                $("#xxap_dept_22").show();
                                                $("#ap_dept_2_x2").attr('data-parsley-required', 'true');

                                            }
                                        });
                                    });
                                    //end
                                    //Show and hide of Person and Dept in Action Plan TAB3
                                    $(function() {
                                        $('#ap_ap_emp3').live('click',function(){
                                             if($('#ap_emp_x3').val() == '') {
                                                $('#xxap_emp_23').hide();
                                                $("#ap_emp_2_x3").val("");
                                            } else {
                                                $('#xxap_emp_23').show();
                                            }
                                        });
                                        $('#ap_emp_2_x3').live('click',function(){
                                            if($(this).val()== "")  {
                                            $("#xxap_dept_23").hide();
                                            $("#ap_dept_2_x3").val("");
                                            $("#ap_dept_2_x3").attr('data-parsley-required', 'false');
                                            }   else {
                                                $("#xxap_dept_23").show();
                                                $("#ap_dept_2_x3").attr('data-parsley-required', 'true');

                                            }
                                        });
                                    });
                                    //end
                                    //Show and hide of Person and Dept in Action Plan TAB4
                                    $(function() {
                                        $('#ap_ap_emp4').live('click',function(){
                                             if($('#ap_emp_x4').val() == '') {
                                                $('#xxap_emp_24').hide();
                                                $("#ap_emp_2_x4").val("");
                                            } else {
                                                $('#xxap_emp_24').show();
                                            }
                                        });
                                        $('#ap_emp_2_x4').live('click',function(){
                                            if($(this).val()== "")  {
                                            $("#xxap_dept_24").hide();
                                            $("#ap_dept_2_x4").val("");
                                            $("#ap_dept_2_x4").attr('data-parsley-required', 'false');
                                            }   else {
                                                $("#xxap_dept_24").show();
                                                $("#ap_dept_2_x4").attr('data-parsley-required', 'true');

                                            }
                                        });
                                    });
                                    //end

                //Clone fields, Update the name attributes and the id's:
                $clone
                .find('[name="code"]').attr('name', 'book[code][' + actionIndex + ']').end()
                .find('[id="code_x"]').attr('id', 'code_x' + actionIndex).end()
                .find('[name="action_plan"]').attr('name', 'book[action_plan][' + actionIndex + ']').end()
                .find('[id="action_plan_x"]').attr('id', 'action_plan_x' + actionIndex).end()
                .find('[name="ap_emp"]').attr('name', 'book[ap_emp][' + actionIndex + ']').end()
                .find('[id="ap_emp_x"]').attr('id', 'ap_emp_x' + actionIndex).end()
                .find('[name="ap_emp_2"]').attr('name', 'book[ap_emp_2][' + actionIndex + ']').end()
                .find('[id="ap_emp_2_x"]').attr('id', 'ap_emp_2_x' + actionIndex).end()
                .find('[name="ap_dept"]').attr('name', 'book[ap_dept][' + actionIndex + ']').end()
                .find('[id="ap_dept_x"]').attr('id', 'ap_dept_x' + actionIndex).end()
                .find('[name="ap_dept_2"]').attr('name', 'book[ap_dept_2][' + actionIndex + ']').end()
                .find('[id="ap_dept_2_x"]').attr('id', 'ap_dept_2_x' + actionIndex).end()
                .find('[name="ap_assigned_audit"]').attr('name', 'book[ap_assigned_audit][' + actionIndex + ']').end()
                .find('[id="ap_assigned_audit_x"]').attr('id', 'ap_assigned_audit' + actionIndex).end()
                .find('[name="ap_project_id"]').attr('name', 'book[ap_project_id][' + actionIndex + ']').end()
                .find('[id="ap_project_id_x"]').attr('id', 'ap_project_id_x' + actionIndex).end()
                .find('[name="ap_status"]').attr('name', 'book[ap_status][' + actionIndex + ']').end()
                .find('[id="ap_status_x"]').attr('id', 'ap_status_x' + actionIndex).end()
                .find('[id="ap_status_xx"]').attr('id', 'ap_status_xx' + actionIndex).end()
                .find('[name="ap_date_tag"]').attr('name', 'book[ap_date_tag][' + actionIndex + ']').end()
                .find('[id="ap_date_tag_x"]').attr('id', 'ap_date_tag_x' + actionIndex).end()
                .find('[name="ap_due_date"]').attr('name', 'book[ap_due_date][' + actionIndex + ']').end()
                .find('[name="ap_date_implemented"]').attr('name', 'book[ap_date_implemented][' + actionIndex + ']').end()
                .find('[id="ap_date_implemented_a"]').attr('id', 'ap_date_implemented_a' + actionIndex).end()
                .find('[id="ap_date_implemented_b"]').attr('id', 'ap_date_implemented_b' + actionIndex).end()
                .find('[name="entered_date"]').attr('name', 'book[entered_date][' + actionIndex + ']').end()
                .find('[id="entered_date_x"]').attr('id', 'entered_date_x' + actionIndex).end()
                .find('[id="_type"]').attr('id', '_type' + actionIndex).end()
                .find('[id="a_status"]').attr('id', 'a_status' + actionIndex).end()
                .find('[id="a_status_2"]').attr('id', 'a_status_2' + actionIndex).end()
                .find('[id="ap_implemented1a"]').attr('id', 'ap_implemented1a' + actionIndex).end()
                .find('[id="ap_implemented2b"]').attr('id', 'ap_implemented2b' + actionIndex).end()
                .find('[id="xxdue_date1"]').attr('id', 'xxdue_date1' + actionIndex).end()
                .find('[id="xxdue_date2"]').attr('id', 'xxdue_date2' + actionIndex).end()
                .find('[id="xxdue_date3"]').attr('id', 'xxdue_date3' + actionIndex).end()
                .find('[id="ap_due_date_x"]').attr('id', 'ap_due_date_x' + actionIndex).end()
                .find('[id="ap_due_date_xx2"]').attr('id', 'ap_due_date_xx2' + actionIndex).end()
                .find('[id="ap_due_date_xx3"]').attr('id', 'ap_due_date_xx3' + actionIndex).end()
                .find('[id="ap_ap_emp"]').attr('id', 'ap_ap_emp' + actionIndex).end()
                .find('[id="ap_ap_dept"]').attr('id', 'ap_ap_dept' + actionIndex).end()
                .find('[id="xxap_emp_2"]').attr('id', 'xxap_emp_2' + actionIndex).end()
                .find('[id="xxap_dept_2"]').attr('id', 'xxap_dept_2' + actionIndex).end()
        });
});
//END OF ACTION PLAN TEMPLATE


//Validation of Impact value of Business Concern
//If impact value is null impact_remarks is not required.
$(document).ready(function(){
    $("#impact_value").keydown(function () {
        if($('#impact_value').val() == "0.00"){
              $('#x_impact_remarks').hide()
              $("#impact_remarks").prop('disabled',true)
              $('#x_impact_remarks2').hide()
              $("#impact_remarks_2").attr('data-parsley-required', 'false');
              $("#impact_remarks_2").val("");
        } else {
              $('#x_impact_remarks2').show()
              $("#impact_remarks_2").attr('data-parsley-required', 'true');
              $("#impact_remarks_2").prop('disabled',false);
              $('#x_impact_remarks').hide()
              $("#impact_remarks").prop('disabled',true)
        }
    });
});
//end

//Validation for action status.
$(function(){
    /*$('.formsave').on('submit',function(e){
    e.preventDefault()
    alert($(this).serialize())
  })*/
    $('#ap_status2x').on('change',function(){
        if($(this).val()== "" || $(this).val()== 2){
          $("#xdue_date2").hide();
          $("#xdue_date3").hide();
          $("#ap_due_date2").prop("disabled", true)
          $("#ap_due_date2").attr('data-parsley-required', 'false');
          $("#ap_due_date3").prop("disabled", true)
          $("#ap_due_date3").attr('data-parsley-required', 'false');
          $("#ap_due_date").prop("disabled", false);
          $("#xdue_date").show();
          $("#ap_due_date").attr('data-parsley-required', 'true');
        }
    });
    $('#ap_status1').on('change',function(){
        if($(this).val()== "" || $(this).val()== 2){
          $("#xdue_date2").hide();
          $("#xdue_date3").hide();
          $("#ap_due_date2").prop("disabled", true)
          $("#ap_due_date2").attr('data-parsley-required', 'false');
          $("#ap_due_date3").prop("disabled", true)
          $("#ap_due_date3").attr('data-parsley-required', 'false');
          $("#ap_due_date").prop("disabled", false);
          $("#xdue_date").show();
          $("#ap_due_date").attr('data-parsley-required', 'true');
        }
    	if($(this).val()== 4){
          $("#xdue_date2").show();
          $("#ap_due_date2").attr('data-parsley-required', 'true');
          $("#ap_due_date2").prop('disabled',false);
          $("#ap_due_date").prop("disabled", true)
          $("#ap_due_date").attr('data-parsley-required', 'false');
          $("#ap_due_date3").prop("disabled", true)
          $("#ap_due_date3").attr('data-parsley-required', 'false');
          $("#xdue_date").hide();
          $("#xdue_date3").hide();
        }
        if($(this).val()== 1 || $(this).val()== 3 || $(this).val()== 5){
          $("#xdue_date3").show();
          $("#ap_due_date3").attr('data-parsley-required', 'true');
          $("#ap_due_date3").prop('disabled',false);
          $("#ap_due_date").prop("disabled", true)
          $("#ap_due_date").attr('data-parsley-required', 'false');
          $("#ap_due_date2").prop("disabled", true)
          $("#ap_due_date2").attr('data-parsley-required', 'false');
          $("#xdue_date").hide();
          $("#xdue_date2").hide();
        }
    });

});
//end

//3 Different Datepicker
$(function(){
    $('.datedayspicker').datepicker({
        dateFormat: 'mm-dd-yyyy',
        //startDate: '-0m'
    }).on('changeDate', function(ev){
        //$('#sDate1').text($('.datedayspicker').data('date'));
        $('.datedayspicker').datepicker('hide');
    });

    $('.datedayspicker2').datepicker({
        dateFormat: 'mm-dd-yyyy',
        startDate: '-0m'
    }).on('changeDate', function(ev){
        $('#sDate1').text($('.datedayspicker2').data('date'));
        $('.datedayspicker2').datepicker('hide');
    });

    $('.datedayspicker3').datepicker({
        dateFormat: 'mm-dd-yyyy',
        endDate: '-0m'
    }).on('changeDate', function(ev){
        $('#sDate1').text($('.datedayspicker3').data('date'));
        $('.datedayspicker3').datepicker('hide');
    });

});
//end

var errorcssobj = {'background': '#EED3D7','border' : '1px solid #ff5b57'};
var errorcssobj2 = {'background': '#cee','border' : '1px solid #00acac'};

//Save
$("#xsave").click(function() {
    var confirm = window.confirm('Do you want to save this Action Plan?');

    if(confirm)
    {

          //alert ("Successfully save");
          $('.formsave').submit();
    }

    else {

        alert('Are you sure you want to cancel');

      return false;
    }
});
//end
//Save bottom
$("#bottomsave").click(function() {
    var confirm = window.confirm('Do you want to save this Action Plan?');

    if(confirm)
    {
          //alert ("Successfully save");
          $('.formsave').submit();
    }
    else {
        alert('Are you sure you want to cancel');

      return false;
    }
});
//end

//Show and hide of Person and Dept in BC
$(function() {
    $('#emp').change(function(){
         if($('#emp').val() == '') {
            $('#xx_emp2').hide();
            $('#xx_emp3').hide();
        } else {
            $('#xx_emp2').show();
            $('#xx_emp3').hide();
        }
    });
    $('#emp2').change(function(){
        if($('#emp2').val() == '') {
            $('#xx_emp3').hide();
        } else {
            $('#xx_emp3').show();
            $('#xx_dept2').show();
        }
    });
    $('#emp3').change(function(){
        if($('#emp3').val() == '') {
            //$('#xx_emp3').hide();
        } else {
            $('#xx_emp3').show();
            $('#xx_dept3').show();
        }
    });
});

$(document).ready(function(){
    $('#xx_emp2').live('click',function(){
        var $id = $("#emp2").val();
            $.ajax({
            url: "",
            type: 'post',
            data: {id: $id},
            success: function(response) {
                    if ($id != "") {
                        $('#xx_dept2').show();
                        $("#dept2").attr('data-parsley-required', 'true');
                    }   else {
                            $("#dept2").attr('data-parsley-required', 'false');
                            $("#dept2").val("");
                            $('#xx_dept2').hide();
                        }
            }
        })
    });
});

$(document).ready(function(){
    $('#xx_emp3').live('click',function(){
        var $id2 = $("#emp3").val();
            $.ajax({
            url: "",
            type: 'post',
            data: {id2: $id2},
            success: function(response) {
                    if ($id2 != "") {
                        $('#xx_dept3').show();
                        $("#dept3").attr('data-parsley-required', 'true');
                    } else {
                        $("#dept3").attr('data-parsley-required', 'false');
                        $("#dept3").val("");
                        $('#xx_dept3').hide();
                    }
            }
        })
    });
});

$(function() {
    $('#dept').change(function(){
         if($('#dept').val() == '') {
            $('#xx_dept2').hide();
            $('#xx_dept3').hide();
        } else {
            //$('#xx_dept2').show();
            $('#xx_dept3').hide();
        }
    });
    $('#dept2').change(function(){
        if($('#dept2').val() == '') {
            $('#xx_dept3').hide();
        } else {
            //$('#xx_dept3').show();
        }
    });
});
//end

$(document).ready(function(){
    $('#xx_ap_emp_2').live('click',function(){
        var $id2 = $("#ap_emp_2").val();
            $.ajax({
            url: "",
            type: 'post',
            data: {id2: $id2},
            success: function(response) {
                    if ($id2 != "") {
                        $('#xx_ap_dept2').show();
                        $("#ap_dept_2").attr('data-parsley-required', 'true');
                    } else {
                        $("#ap_dept_2").attr('data-parsley-required', 'false');
                        $("#ap_dept_2").val("");
                        $('#xx_ap_dept2').hide();
                    }
            }
        })
    });
});

//Show and hide of Person and Dept in Action Plan
$(function() {
    $('#ap_emp').change(function(){
         if($('#ap_emp').val() == '') {
            $('#xx_ap_emp_2').hide();
        } else {
            $('#xx_ap_emp_2').show();
            //$('#xx_ap_dept2').show();
        }
    });
    $('#ap_dept').change(function(){
         if($('#ap_dept').val() == '') {
            $('#xx_ap_dept2').hide();
        } else {
            //$('#xx_ap_dept2').show();
        }
    });
});
//end

//FOR ACTION PLAN AJAX
$(function() {
    $('#ap_risk1').change(function(){
         if($('#ap_risk1').val() == '') {
            $('#aprisk2').hide();
            $('#aprisk3').hide();
        } else {
            $('#aprisk2').show();
        }
    });
    $('#ap_risk2').change(function(){
        if($('#ap_risk2').val() == '') {
            $('#aprisk3').hide();
        } else {
            $('#aprisk3').show();
        }
    });
});
//end

$("#ap_risk1").change(function() {
    var $id = $("#ap_risk1").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxgetapRisk1')?>",
        type: 'post',
        data: {id: $id},
        success: function(response) {
            var $response = $.parseJSON(response);
            $('#ap_risk2').empty();
            var option1 = $('<option>').val('').text('------');
            $('#ap_risk2').append(option1);
            $.each($response['ap_risk2'], function(x)
             {
                 var xitem = $response['ap_risk2'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#ap_risk2').append(option2);
             });

            $('#ap_risk3').empty();
            var option1 = $('<option>').val('').text('------');
            $('#ap_risk3').append(option1);
            $.each($response['ap_risk3'], function(x)
             {
                 var xitem = $response['ap_risk3'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#ap_risk3').append(option2);
             });
        }

    });

});

$("#ap_risk2").change(function() {
    var $id = $("#ap_risk2").val();
    var $id3 = $("#ap_risk3").val();
    var $id1 = $("#ap_risk1").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxgetapRisk2')?>",
        type: 'post',
        data: {id: $id, id1: $id1, id3: $id3},
        success: function(response) {
            var $response = $.parseJSON(response);
            $('#ap_risk3').empty();
            var option1 = $('<option>').val('').text('------');
            $('#ap_risk3').append(option1);
            $.each($response['ap_risk3'], function(x)
             {
                 var xitem = $response['ap_risk3'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#ap_risk3').append(option2);
             });

            //$('#risk1').empty();
            var option1 = $('<option>').val('').text('------');
            $('#ap_risk1').append(option1);
            $.each($response['ap_risk1'], function(x)
             {
                 var xitem = $response['ap_risk1'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#ap_risk1').append(option2);
             });
        }
    });
});
//end of ACTION PLAN AJAX

//Show and hide of business_concern
$(function() {
    $('#risk1').change(function(){
         if($('#risk1').val() == '') {
            $('#_risk2').hide();
            $('#_risk3').hide();
        } else {
            $('#_risk2').show();
        }
    });
    $('#risk2').change(function(){
        if($('#risk2').val() == '') {
            $('#_risk3').hide();
        } else {
            $('#_risk3').show();
        }
    });
});
//end
$("#risk1").change(function() {
    var $id = $("#risk1").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxgetRisk1')?>",
        type: 'post',
        data: {id: $id},
        success: function(response) {
            var $response = $.parseJSON(response);
            $('#risk2').empty();
            var option1 = $('<option>').val('').text('------');
            $('#risk2').append(option1);
            $.each($response['risk2'], function(x)
             {
                 var xitem = $response['risk2'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#risk2').append(option2);
             });

            $('#risk3').empty();
            var option1 = $('<option>').val('').text('------');
            $('#risk3').append(option1);
            $.each($response['risk3'], function(x)
             {
                 var xitem = $response['risk3'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#risk3').append(option2);
             });
        }

    });

});

$("#risk2").change(function() {
    var $id = $("#risk2").val();
    var $id3 = $("#risk3").val();
    var $id1 = $("#risk1").val();
    $.ajax({
        url: "<?php echo site_url('entry/ajaxgetRisk2')?>",
        type: 'post',
        data: {id: $id, id1: $id1, id3: $id3},
        success: function(response) {
            var $response = $.parseJSON(response);
            $('#risk3').empty();
            var option1 = $('<option>').val('').text('------');
            $('#risk3').append(option1);
            $.each($response['risk3'], function(x)
             {
                 var xitem = $response['risk3'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#risk3').append(option2);
             });

            //$('#risk1').empty();
            var option1 = $('<option>').val('').text('------');
            $('#risk1').append(option1);
            $.each($response['risk1'], function(x)
             {
                 var xitem = $response['risk1'][x];
                 var option2 = $('<option>').val(xitem['id']).text(xitem['description']);
                 $('#risk1').append(option2);
             });
        }
    });
});

document.getElementById('bc_status').addEventListener('change', function () {
    var style = this.value == 9 ? 'block' : 'none';
    document.getElementById('a_status').style.display = style;
});

document.getElementById('bc_status').addEventListener('change', function () {
    var style = this.value == 10 ? 'block' : 'none';
    document.getElementById('a_status_2').style.display = style;
});

//for business concern STATUS validation:
$(document).ready(function(){
    $("#b_status").change(function(){
        var $id = $("#bc_status").val();
        $.ajax({
           url: "<?php echo site_url('entry/ajaxstatus')?>",
           type: 'post',
           data: {id: $id},
           success: function(response) {
            if ($id != 10) {
                $("#date_tag").val("");
                $("#d_implemented1").show();
                $("#date_implemented").attr('disabled', 'true');
                $("#d_implemented2").hide();
                $("#_status").show();
                $("#_status2").hide();
                $("#ap_status1").attr('data-parsley-required', 'true');
                $("#ap_status2x").attr('data-parsley-required', 'false');
                $("#date_implementedx").attr('data-parsley-required', 'false');
                $("#date_implementedx").val("");
            }   else{
                    $("#date_tag").val('<?php echo date('F j\, Y \ l') ?>');
                    $("#d_implemented1").hide();
                    $("#date_implemented").attr('disabled', 'false');
                    $("#d_implemented2").show();
                    $("#_status").hide();
                    $("#_status2").show();
                    $("#ap_status1").attr('data-parsley-required', 'false');
                    $("#ap_status2x").attr('data-parsley-required', 'true');
                    $("#date_implementedx").attr('data-parsley-required', 'true');
                }
            }
        })
    });
});

//For Action Plan STATUS validation:
$(document).ready(function(){
    $("#_status").change(function(){
        var $id = $("#ap_status1").val();
            $.ajax({
            url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
            type: 'post',
            data: {id: $id},
            success: function(response) {
                    if ($id != 2) {
                        $("#ap_date_tag").val("");
                        $("#ap_implemented1").show();
                        $("#ap_date_implemented").attr('disabled', 'true');
                        $("#ap_implemented2").hide();
                        $("#ap_date_implemented").attr('data-parsley-required', 'false');
                        $("#ap_date_implementedx").attr('data-parsley-required', 'false');
                        $("#ap_date_implementedx").val("");

                    }   else {
                            $("#ap_date_tag").val('<?php echo date('F j\, Y \ l') ?>');
                            $("#ap_implemented1").hide();
                            $("#ap_date_implemented").attr('disabled', 'false');
                            $("#ap_implemented2").show();
                            $("#ap_date_implemented").attr('data-parsley-required', 'false');
                            $("#ap_date_implementedx").attr('data-parsley-required', 'true');
                        }
            }
        })
    });
    //For Action Plan STATUS validation:
    $("#_status2").change(function(){
        var $id = $("#ap_status2x").val();
            $.ajax({
            url: "<?php echo site_url('entry/ap_ajaxstatus')?>",
            type: 'post',
            data: {id: $id},
            success: function(response) {
                if ($id != 2) {
                    $("#ap_date_tag").val('');
                    $("#ap_date_implemented").attr('data-parsley-required', 'false');
                    $("#ap_date_implementedx").attr('data-parsley-required', 'false');
                    $("#ap_due_date").attr('data-parsley-required', 'false');
                    $("#ap_date_implementedx").val("");
                }   else {
                        $("#ap_date_tag").val('<?php echo date('F j\, Y \ l') ?>');
                        $("#ap_implemented1").hide();
                        $("#ap_date_implemented").attr('disabled', 'false');
                        $("#ap_implemented2").show();
                        $("#ap_date_implemented").attr('data-parsley-required', 'false');
                        $("#ap_date_implementedx").attr('data-parsley-required', 'true');
                    }
            }
        })
    });
});

$("#refresh").click(function() {
    var confirm = window.confirm('Are you sure you want to Reload');

    if(confirm)
    {
        //alert('System will reload press ok');
        window.location.reload()
    }
    else {
        alert('Are you sure you want to cancel');
    }
});

$(document).ready(function(){
  $("#add").click(function(){
      $('#business_concern').html('Business');
  });
});

function reloading() {
	if($('#impact_value').val() == ""){
        $("#impact_remarks_2").attr('data-parsley-required', 'false');
        $("#impact_remarks_2").attr('data-parsley-validate', 'false');
		$("#impact_remarks_2").attr('data-parsley-group', 'wizard-step-1');
    }   else {
            $('#impact_remarks').hide()
        }
}
window.onload = reloading;


</script>
