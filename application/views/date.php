
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="javascript:;">Home</a></li>
                <li><a href="javascript:;">Form Stuff</a></li>
                <li class="active">Form Plugins</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Form Plugins <small>header small text goes here...</small></h1>
            <!-- end page-header -->
            
            <!-- begin row -->
            <div class="row">
                <!-- begin col-6 -->
                <div class="col-md-6">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Datepicker</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered">
                            
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Default Datepicker</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="datepicker-default" placeholder="Select Date" value="04/1/2014" />
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Inline Datepicker</label>
                                    <div class="col-md-8">
                                        <div id="datepicker-disabled-past"><div></div></div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Auto Close Datepicker</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="datepicker-disabled-past" placeholder="Auto Close Datepicker" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Disabled Past Date</label>
                                    <div class="col-md-8">
                                        <div class="input-group date" id="datepicker-disabled-past" data-date-format="dd-mm-yyyy" data-date-start-date="Date.default">
                                            <input type="text" class="form-control" placeholder="Select Date" />
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Range Datepicker</label>
                                    <div class="col-md-8">
                                        <div class="input-group input-daterange">
                                            <input type="text" class="form-control" name="start" placeholder="Date Start" />
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="form-control" name="end" placeholder="Date End" />
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    <!-- end panel -->
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">jQuery Autocomplete</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Autocomplete</label>
                                    <div class="col-md-8">
                                        <input type="text" name="" id="jquery-autocomplete" class="form-control" placeholder="Try typing 'a' or 'b'." />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end panel -->
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Bootstrap Combobox</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Bootstrap Combobox</label>
                                    <div class="col-md-8">
                                        <select class="combobox">
                                            <option value="">Select Location</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="CT">Connecticut</option>
                                            <option value="NY">New York</option>
                                            <option value="MD">Maryland</option>
                                            <option value="VA">Virginia</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end panel -->
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Select with Search</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Default</label>
                                    <div class="col-md-8">
                                        <p>Convert this</p>
                                        <select class="form-control">
                                            <option value="" selected>Select a Country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                        </select>
                                        <p></p>
                                        <p>Become this</p>
                                        <select class="form-control selectpicker" data-size="10" data-live-search="true">
                                            <option value="" selected>Select a Country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Theme White</label>
                                    <div class="col-md-8">
                                        <select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white">
                                            <option value="" selected>Select a Country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Theme Inverse</label>
                                    <div class="col-md-8">
                                        <select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-inverse">
                                            <option value="" selected>Select a Country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Theme Primary</label>
                                    <div class="col-md-8">
                                        <select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-primary">
                                            <option value="" selected>Select a Country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Theme Info</label>
                                    <div class="col-md-8">
                                        <select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-info">
                                            <option value="" selected>Select a Country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Theme Success</label>
                                    <div class="col-md-8">
                                        <select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-success">
                                            <option value="" selected>Select a Country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Theme Warning</label>
                                    <div class="col-md-8">
                                        <select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-warning">
                                            <option value="" selected>Select a Country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Theme Danger</label>
                                    <div class="col-md-8">
                                        <select class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-danger">
                                            <option value="" selected>Select a Country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end panel -->
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Password Indicator</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Password</label>
                                    <div class="col-md-8">
                                        <input type="password" name="password" id="password-indicator-default" class="form-control m-b-5" />
                                        <div id="passwordStrengthDiv" class="is0 m-t-5"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Visible Password</label>
                                    <div class="col-md-8">
                                        <input type="text" name="password-visible" id="password-indicator-visible" class="form-control m-b-5" />
                                        <div id="passwordStrengthDiv2" class="is0 m-t-5"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-6 -->
                <!-- begin col-6 -->
                <div class="col-md-6">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Colopicker & Timepicker</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Default Color Picker</label>
                                    <div class="col-md-8">
                                        <input type="text" value="#3498db" class="form-control" id="colorpicker" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Prepend Color Picker</label>
                                    <div class="col-md-8">
                                        <div class="input-group colorpicker-component" data-color="rgb(0, 0, 0)" data-color-format="rgb"  id="colorpicker-prepend">
                                            <input type="text" value="rgb(0, 0, 0)" readonly="" class="form-control" />
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">RGBA Color format</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="rgb(155,89,182,0.8)" id="colorpicker-rgba" data-color-format="rgba" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Default timepicker</label>
                                    <div class="col-md-8">
                                        <div class="input-group bootstrap-timepicker">
                                            <input id="timepicker" type="text" class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end panel -->
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Ion Range Slider</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Default</label>
                                    <div class="col-md-8">
                                        <input type="text" id="default_rangeSlider" name="default_rangeSlider" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Custom Range</label>
                                    <div class="col-md-8">
                                        <input type="text" id="customRange_rangeSlider" name="default_rangeSlider" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Custom Values</label>
                                    <div class="col-md-8">
                                        <input type="text" id="customValue_rangeSlider" name="default_rangeSlider" value="" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end panel -->
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Masked Input</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Date</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="masked-input-date" placeholder="dd/mm/yyyy" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Phone</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="masked-input-phone" placeholder="(999) 999-9999" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tax ID</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="masked-input-tid" placeholder="99-9999999" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Product Key</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="masked-input-pkey" placeholder="a*-999-a999" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">SSN</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="masked-input-ssn" placeholder="999/99/9999" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">SSN</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="masked-input-pno" placeholder="AAA-9999-A" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end panel -->
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">jQuery Tag It</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Default Tags Input with Autocomplete</label>
                                    <div class="col-md-8">
                                        <ul id="jquery-tagIt-default">
                                            <li>Tag1</li>
                                            <li>Tag2</li>
                                        </ul>
                                        <p>Try to enter "c++, java, php" </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Inverse Theme</label>
                                    <div class="col-md-8">
                                        <ul id="jquery-tagIt-inverse" class="inverse">
                                            <li>Tag1</li>
                                            <li>Tag2</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">White Theme</label>
                                    <div class="col-md-8">
                                        <ul id="jquery-tagIt-white" class="white">
                                            <li>Tag1</li>
                                            <li>Tag2</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Primary Theme</label>
                                    <div class="col-md-8">
                                        <ul id="jquery-tagIt-primary" class="primary">
                                            <li>Tag1</li>
                                            <li>Tag2</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Info Theme</label>
                                    <div class="col-md-8">
                                        <ul id="jquery-tagIt-info" class="info">
                                            <li>Tag1</li>
                                            <li>Tag2</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Success Theme</label>
                                    <div class="col-md-8">
                                        <ul id="jquery-tagIt-success" class="success">
                                            <li>Tag1</li>
                                            <li>Tag2</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Warning Theme</label>
                                    <div class="col-md-8">
                                        <ul id="jquery-tagIt-warning" class="warning">
                                            <li>Tag1</li>
                                            <li>Tag2</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Danger Theme</label>
                                    <div class="col-md-8">
                                        <ul id="jquery-tagIt-danger" class="danger">
                                            <li>Tag1</li>
                                            <li>Tag2</li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-6 -->
            </div>
            <!-- end row -->

        
        
        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->
    
    

