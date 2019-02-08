<!-- Login Form -->
<div class="modal fade" id="loginForm" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{'login_form_title' | translate}}</h4>
                <button type="button" class="close mt-1" data-dismiss="modal">&times;</buttwz-stepon>
            </div>
            <div class="modal-body">
                <!-- Centered Tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="javascript:void(0)" data-target="#login">{{'text.login' | translate}}</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="javascript:void(0)" class="nav-link" data-target="#register">{{'text.register' | translate}}</a></li>
                </ul>

                <div class="tab-content mt-4">
                    <div id="login" class="tab-pane active" ng-controller="LoginCtrl">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="alert alert-danger" ng-show="err">{{errorMessage}}</p>
                                <form name="LoginForm" ng-submit="!loading && loginsubmit(LoginForm)" autocomplete="off" ng-validate="loginValidationOptions">
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{'basic_details.email' | translate}} <span class="required">*</span></label>
                                        <input id="email" type="text" name="email" ng-model="logindata.email" class="form-control" placeholder="{{'basic_details.email' | translate}}" ng-disabled="loading" autofocus />
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">{{'basic_details.password' | translate}} <span class="required">*</span></label>
                                        <input id="password" type="password" name="password" ng-model="logindata.password"  class="form-control" placeholder="{{'basic_details.password' | translate}}" ng-disabled="loading" />
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" id="login-btn" class="form-control btn btn-primary">{{'text.login' | translate}}</button>
                                    </div>

                                    
                                    <div class="form-group text-center">
                                        <a href="javascript:void(0)" id="forgot-pwd-link" class="text-decoration-none" onclick="openForgotPasswordModal()">
                                            {{'forgot_password' | translate}}
                                        </a>
                                    </div>
                                </form>

                                <div class="form-group text-center">
                                    <a href="javascript:void(0)" onclick="loginWithFacebook()" class="fb-btn">
                                        <i class="fa fa-facebook-square fa-fw"></i> Login with Facebook
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div ng-include="'loader.html'" ng-if="loading"></div>

                    </div>
                    <div id="register" class="tab-pane fade" ng-controller="SignupCtrl">
                        <div class="row">
                            <div class="col-md-12">
      
                                <p class="alert alert-danger" ng-show="err">{{errorMessage}} <a href="javascript:jQuery('#loginForm .nav-tabs>li:first>a').tab('show');" data-target="#login" ng-if="errorMessage.indexOf(signupdata.email) !== -1" >{{'text.login' | translate}}</a></p>
                                <p class="alert alert-danger" ng-show="required"> {{field}} !!!</p>

                                <form name="RegisterForm" autocomplete="off" ng-submit="!loading && signupsubmitform(RegisterForm)" ng-validate="basicDetailsValidationOptions">
                                    <div class="form-group">
                                        <label for="fullname" class="form-label">{{'basic_details.name' | translate}} <span class="required">*</span></label>
                                        <input type="text" name="fullname" class="form-control" placeholder="{{'basic_details.name' | translate}}" ng-model="signupdata.name" ng-disabled="loading" autofocus />
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{'basic_details.email' | translate}} <span class="required">*</span></label>
                                        <input type="email" name="email" class="form-control" placeholder="{{'basic_details.email' | translate}}" ng-model="signupdata.email" ng-disabled="loading" />
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">{{'basic_details.password' | translate}} <span class="required">*</span></label>
                                        <input type="password" name="password" class="form-control" placeholder="{{'basic_details.password' | translate}}" ng-model="signupdata.password" ng-disabled="loading" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">{{'basic_details.phone' | translate}} <span class="required">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong>+45</strong></span>
                                            </div>
                                            <input type="text" name="phone" class="form-control" ng-model="signupdata.phone" ui-mask="99-99-99-99" ng-disabled="loading" />
                                        </div>
                                        <label id="phone-error" class="error" for="phone"></label>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-primary" id="register-btn" ng-disabled="loading">{{'text.register_now' | translate}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <a href="javascript:void(0)" onclick="loginWithFacebook()" class="fb-btn">
                                <i class="fa fa-facebook-square fa-fw"></i> Register with Facebook
                            </a>
                        </div>

                        <div ng-include="'loader.html'" ng-if="loading"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Login Form -->

<!-- Logout Form -->
<div class="modal fade" id="logoutForm" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content" ng-controller="LogoutCtrl">
            <div class="modal-header">
                <h4 class="modal-title">{{'text.logout' | translate}}</h4>
                <button type="button" class="close mt-1" data-dismiss="modal" ng-disabled="loading">&times;</button>
            </div>
            <div class="modal-body">
                <p class="alert alert-danger" ng-show="err">{{errorMessage}}</p>
                <h4>{{'logout_form_heading_text' | translate}}</h4>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-primary" ng-disabled="loading" ng-click="!loading && logout()">{{'text.yes' | translate}}</button>
                <button type="button" class="btn btn-default" ng-disabled="loading" data-dismiss="modal">{{'text.no' | translate}}</button>
            </div>
        </div>
    </div>
</div>
<!-- End Login Form -->

<!-- Request Pickup -->
<div class="modal fade" id="requestPickupModal" role="dialog" data-backdrop="static" data-keyboard="false" ng-controller="OrdersummaryCtrl">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="text-center mb-3">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo-top.png" class="popup-top-logo img-responsive" />
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <div class="myorder Deliverydate finaldate" ng-if="!showLoading && !orderCreationDone">
                    <wizard on-finish="finished()" indicators-position="top" name="requestPickupWizard" edit-mode="true" ng-init="initializeWizard()">
                        <wz-step wz-title="0" wz-disabled="{{isUserLoggedIn}}" wz-heading-title="{{Steps.partial_user_detail}}" canenter="validateStep">
                            <div class="row my-3 title">
                                <div class="col-sm-10 pr-0 col-10">
                                    <h4 class="pull-left">{{'start_text' | translate}} :-)</h4>
                                </div>
                                <div class="col-sm-2 col-2">
                                    <button type="button" class="close pull-right" ng-click="onCancelOrder()">&times;</button>
                                </div>
                            </div>
                            
                            <form name="{{Steps.partial_user_detail}}" id="{{Steps.partial_user_detail}}" ng-validate="userDetailsValidationOptions">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="alert alert-danger" ng-show="userErr">{{userErrorMessage}}</p>

                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label class="font-weight-bold">{{'basic_details.name' | translate}}</label>
                                                <input type="text" name="fullname" class="form-control" ng-model="userDetails.full_name" ng-disabled="loading" autofocus />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label class="font-weight-bold">{{'basic_details.phone' | translate}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><strong>+45</strong></span>
                                                    </div>
                                                    <input type="text" name="phone" class="form-control" ng-model="userDetails.phone" ui-mask="99-99-99-99" ng-disabled="loading" />                                                
                                                </div>
                                                <label id="phone-error" class="error" for="phone"></label>
                                            </div>

                                            <div class="form-group col-sm-12">
                                                <label class="font-weight-bold">{{'address_details.city' | translate}}</label>
                                                <select ng-model="addressDetails.city_id" ng-disabled="loading" name="city" class="form-control">
                                                    <option value="">{{'text.select' | translate}} {{'address_details.city' | translate}}</option>
                                                    <option ng-repeat="value in cityData" value="{{value.id}}">
                                                        {{value.title}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="round_button action-btn pull-right" ng-click="performAction('SAVE_USER_PARTIAL_INFORMATION')">{{'text.next' | translate}}</button>
                                    </div>
                                </div>
                            </form>

                            <div ng-include="'loader.html'" ng-if="loading"></div>
                        </wz-step>

                        <wz-step wz-title="1" wz-heading-title="{{Steps.pickup_date}}" canenter="validateStep">
                            <div class="row my-3 title">
                                <div class="col-sm-10 pr-0 col-10">
                                    <h4 class="pull-left">{{'request_pickup_date' | translate}}</h4>
                                </div>
                                <div class="col-sm-2 col-2">
                                    <button type="button" class="close pull-right" ng-click="onCancelOrder()">&times;</button>
                                </div>
                            </div>


                            <div class="row" ng-repeat="value in pickupDateList" ng-hide="!showAllpickupDateList && $index > 3" ng-click="performAction('SAVE_PICKUP_DATE', value)"
                                ng-class="{
                                            'today-div': value.name == 'Today',
                                            'tomorrow-div': value.name == 'Tomorrow',
                                        }">
                                <div class="col-sm-12" ng-class="{'active': localData.pickupDate && (localData.pickupDate.date | date: 'yyyy-mm-dd') == (value.date | date: 'yyyy-mm-dd') }">
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-sm-8 col-8">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h5 class="text-capitalize">{{value.name}}</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 lighter-text">{{value.subname != ''?value.subname + ', ':''}}{{value.shortDate}} </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-4">
                                                <span class="round_button fixed-width-btn pull-right" ng-if="value.price"> + {{value.price | currency}}</span>
                                                <span class="round_button fixed-width-btn pull-right" ng-if="!value.price">{{'text.free' | translate}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" ng-if="!showAllpickupDateList">
                                <div ng-click="loadMorePickupDates()" class="col-sm-12">
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h5>{{'text.other' | translate}}</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">{{value.shortDate}} </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <span class="round_button fixed-width-btn pull-right" ng-if="value.price">{{value.price | currency}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" ng-if="!isUserLoggedIn">
                                <div class="col-sm-12">
                                    <button class="round_button action-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="2" wz-heading-title="{{Steps.pickup_time}}" canenter="validateStep">
                            <div class="row my-3 title">
                                <div class="col-sm-10 pr-0 col-10">
                                    <h4 class="pull-left">{{'request_pickup_time' | translate}}</h4>
                                </div>
                                <div class="col-sm-2 col-2">
                                    <button type="button" class="close pull-right" ng-click="onCancelOrder()">&times;</button>
                                </div>
                            </div>

                            <div id="div_slots">
                                <div class="row" ng-repeat="value in TimeSlots" ng-class="{'active': localData.pickupTime && localData.pickupTime.id == value.id }">
                                    <div class="col-sm-12">
                                        <div class="card-box" wz-next="performAction('SELECT_PICKUP_TIME', value)">
                                            <div class="row">
                                                <div class="col-sm-3 col-3 text-center">
                                                    <img width="70" ng-src="<?php echo get_template_directory_uri(); ?>/images/{{value.time_from}}.png" />
                                                </div>
                                                <div class="col-sm-6 col-6">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- we do not have one hour slot option now -->
                                                            <!-- <span ng-if="value.type == 1">FLEXIBLE </span>
                                                            <span ng-if="value.type == 2"> ONE HOUR SLOT </span> -->
                                                            <h6 class="text-capitalize"> {{'text.between' | translate}} </h6>
                                                            <h5 class='larger'> {{value.time_from}}:00 to {{value.time_to}}:00 </h5>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 mt-3 col-3">
                                                    <span class="round_button fixed-width-btn pull-right" ng-if="value.price > 0">+ {{value.price | currency}}</span>
                                                    <span class="round_button fixed-width-btn pull-right" ng-if="!(value.price > 0)">{{'text.free' | translate}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="row">
                                    <div class="col-sm-12 text-center text-upper mb-3">{{'text.or' | translate}}</div>
                                </div> -->

                                <div class="row" ng-class="{'active': localData.pickupTime && localData.pickupTime.leaveAtdoor == 'y' }">
                                    <div class="col-sm-12">
                                        <div class='card-box' wz-next="performAction('SELECT_PICKUP_AT_DOOR', '')">
                                            <div class="row">
                                                <div class="col-sm-3 col-3 text-center">
                                                    <img width="70" ng-src="<?php echo get_template_directory_uri(); ?>/images/no_time.png" />
                                                </div>
                                                <div class="col-sm-6 mt-1 col-6">
                                                    <div class="title">
                                                        <h5> {{'request_pickup_leave_at_door' | translate}} </h5>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 mt-3 col-3">
                                                    <span class="round_button fixed-width-btn pull-right"> {{'text.free' | translate}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="round_button action-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    </div>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="3" wz-disabled="{{!isUserLoggedIn && set_order_system == 'QUICK'}}" wz-heading-title="{{Steps.drop_date}}" canenter="validateStep">
                            <div class="row my-3 title">
                                <div class="col-sm-12 col-12">
                                    <h4 class="pull-left">{{'request_drop_date' | translate}}</h4>
                                </div>
                                <!-- <div class="col-sm-2 col-2">
                                    <button type="button" class="close pull-right" ng-click="onCancelOrder()">&times;</button>
                                </div> -->
                            </div>

                            <div class="row" ng-repeat="value in deliveryDateList" ng-hide="!showAlldeliveryDateList && $index > 3"
                                wz-next="performAction('SAVE_DELIVERY_DATE', value)" ng-class="{
                                                    'tomorrow-div': value.name == 'Tomorrow',
                                                    'day-after-div': value.name == 'day after',
                                                }">
                                <div class="col-sm-12" ng-class="{'active': localData.deliveryDate && (localData.deliveryDate.date | date: 'yyyy-mm-dd') == (value.date | date: 'yyyy-mm-dd') }">
                                    <div class="card-box" >
                                        <div class="row">
                                            <div class="col-sm-8 col-8">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h5 class='text-capitalize'>{{value.name}}</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 lighter-text">{{value.subname != ''?value.subname + ', ':''}}{{value.shortDate}} </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-4">
                                                <span class="round_button fixed-width-btn pull-right" ng-if="value.price">+ {{value.price | currency}}</span>
                                                <span class="round_button fixed-width-btn pull-right" ng-if="!value.price">{{'text.free' | translate}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" ng-if="!showAlldeliveryDateList">
                                <div class="col-sm-12" ng-click="loadMoreDeliveryDates()">
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-sm-8 col-8">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h5>{{'text.other' | translate}}</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">{{value.shortDate}} </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-4">
                                                <span class="round_button fixed-width-btn" ng-if="value.price">+ {{value.price | currency}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="round_button action-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="4" wz-disabled="{{!isUserLoggedIn && set_order_system == 'QUICK'}}" wz-heading-title="{{Steps.drop_time}}" canenter="validateStep">
                            <div class="row my-3 title">
                                <div class="col-sm-12 col-12">
                                    <h4 class="pull-left">{{'request_drop_time' | translate}}</h4>
                                </div>
                                <!-- <div class="col-sm-2 col-2">
                                    <button type="button" class="close pull-right" ng-click="onCancelOrder()">&times;</button>
                                </div> -->
                            </div>

                            <div id="div_slots">
                                <div class="row" ng-repeat="value in TimeSlots" ng-class="{'active': localData.deliveryTime && localData.deliveryTime.id == value.id }">
                                    <div class="col-sm-12">
                                        <div class="card-box" wz-next="performAction('SELECT_DELIVERY_TIME', value)">
                                            <div class="row">
                                                <div class="col-sm-3 col-3 text-center">
                                                    <img width="70" ng-src="<?php echo get_template_directory_uri(); ?>/images/{{value.time_from}}.png" />
                                                </div>
                                                <div class="col-sm-6 col-6">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h6 class="text-captalize"> {{'text.between' | translate}} </h6>
                                                            <h5 class="text-upper larger"> {{value.time_from}}:00 {{'text.to' | translate}} {{value.time_to}}:00 </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-3">
                                                <span class="round_button fixed-width-btn pull-right" ng-if="value.price > 0">+ {{value.price | currency}}</span>
                                                    <span class="round_button fixed-width-btn pull-right" ng-if="!(value.price > 0)">{{'text.free' | translate}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" ng-class="{'active': localData.deliveryTime && localData.deliveryTime.leaveAtdoor == 'y' }">
                                    <div class="col-sm-12">
                                        <div class="card-box" wz-next="performAction('SELECT_DELIVERY_AT_DOOR', '')">
                                            <div class="row">
                                                <div class="col-sm-3 col-3 text-center">
                                                    <img width="70" ng-src="<?php echo get_template_directory_uri(); ?>/images/no_time.png" />
                                                </div>
                                                <div class="col-sm-6 col-6 mt-1">
                                                    <div class="item ">
                                                        <h5> {{'request_drop_leave_at_door' | translate}} </h5>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-3 mt-3">
                                                    <span class="round_button fixed-width-btn pull-right"> {{'text.free' | translate}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="round_button action-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    </div>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="5" wz-heading-title="{{Steps.user_detail}}" wz-disabled="{{isUserLoggedIn || (!isUserLoggedIn && set_order_system == 'QUICK')}}" canenter="validateStep">
                            <div class="row title my-3">
                                <div class="col-sm-12 col-12">
                                    <h4 class="pull-left">{{'request_pickup_enter_basic_details' | translate}}</h4>
                                </div>
                                <!-- <div class="col-sm-2 col-2">
                                    <button type="button" class="close pull-right" ng-click="onCancelOrder()">&times;</button>
                                </div> -->
                            </div>
                            <form name="{{Steps.user_detail}}" id="{{Steps.user_detail}}" ng-validate="basicDetailsValidationOptions">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="alert alert-danger" ng-show="userErr">{{userErrorMessage}}. {{'text.click_here' | translate}} {{'text.to' | translate}} <a href="javascript:void(0)" ng-if="userErrorMessage.indexOf(userDetails.email) !== -1" ng-click="showModal('#loginForm');">{{'text.login' | translate}}</a></p>
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{'basic_details.name' | translate}}</label>
                                            <input type="text" name="fullname" class="form-control" ng-model="userDetails.full_name" ng-disabled="loading" autofocus />
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{'basic_details.email' | translate}}</label>

                                            <input type="email" name="email" class="form-control" ng-model="userDetails.email" ng-disabled="loading" />
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{'basic_details.password' | translate}}</label>
                                            <input type="password" name="password" class="form-control" ng-model="userDetails.password" ng-disabled="loading" />
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{'basic_details.phone' | translate}}</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><strong>+45</strong></span>
                                                </div>
                                                <input type="text" name="phone" class="form-control" ng-model="userDetails.phone" ui-mask="99-99-99-99" ng-disabled="loading" />
                                            </div>
                                            <label id="phone-error" class="error" for="phone"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="round_button action-btn pull-right" ng-click="performAction('SAVE_USER_DETAILS')">{{'text.next' | translate}}</button>
                                        <button class="round_button action-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    </div>
                                </div>
                            </form>

                            <div ng-include="'loader.html'" ng-if="loading"></div>
                        </wz-step>

                        <wz-step wz-title="{{isUserLoggedIn && showAddressDetailStep?'5':'6'}}" wz-heading-title="{{Steps.address_detail}}" wz-disabled="{{(isUserLoggedIn && showAddressDetailStep == false) || (!isUserLoggedIn && set_order_system == 'QUICK')}}" canenter="validateStep">
                            <div class="row title my-3">
                                <div class="col-sm-12 col-12">
                                    <h4 class="pull-left">{{'request_pickup_enter_address_details' | translate}}</h4>
                                </div>
                                <!-- <div class="col-sm-2 col-2">
                                    <button type="button" class="close pull-right" ng-click="onCancelOrder()">&times;</button>
                                </div> -->
                            </div>

                            <form name="{{Steps.address_detail}}" id="{{Steps.address_detail}}" ng-validate="addressDetailsValidationOptions">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="alert alert-danger" ng-show="addressErr">{{addressErrorMessage}}</p>
                                            <div ng-include="'address-form.html'" ></div>
                                        
                                    </div>
                                </div>
                                <!-- <form name="{{Steps.address_detail}}" id="{{Steps.address_detail}}" ng-validate="addressDetailsValidationOptions">
                                    <div ng-include="'address-form.html'"></div>
                                </form> -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="round_button action-btn pull-right" ng-click="performAction('SAVE_ADDRESS_DETAILS', true)">{{'text.next' | translate}}</button>
                                        <button class="round_button action-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    </div>
                                </div>
                            </form>
                            <div ng-include="'loader.html'" ng-if="loading"></div>
                        </wz-step>

                        <wz-step wz-title="{{isUserLoggedIn && showPaymentDetailStep?(showAddressDetailStep?'6':'5'):'7'}}" wz-heading-title="{{Steps.payment_detail}}" wz-disabled="{{(isUserLoggedIn && showPaymentDetailStep == false) || (!isUserLoggedIn && set_order_system == 'QUICK')}}" canenter="validateStep">
                            <div class="row title my-3">
                                <div class="col-sm-10 col-10">
                                    <h4 class="pull-left">{{'request_pickup_enter_payemnt_details' | translate}}</h4>
                                </div>
                                <div class="col-sm-2 col-2">
                                    <button type="button" class="close pull-right" ng-click="onCancelOrder()">&times;</button>
                                </div>
                            </div>

                            <div ng-include="'vault-form.html'"></div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="round_button action-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    <a class="pull-right mt-4" href="javascript:void(0)" ng-click="reloadPaymentWindow()">{{'text.reload_Payment_window' | translate}}</a>
                                    <button class="round_button action-btn pull-right visiblity-none" id="orderLoadVaults" ng-click="performAction('GET_PAYMENT_DETAILS')">{{'text.next' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="{{lastStepNumber}}" wz-heading-title="{{Steps.order_summary}}" wz-disabled="!isUserLoggedIn && set_order_system == 'QUICK'" canenter="validateStep">
                            <div class="row title my-3">
                                <div class="col-sm-12">
                                    <h4 class="pull-left">{{'request_pickup_order_summary' | translate}}</h4>
                                </div>
                                <!-- <div class="col-sm-2 col-2">
                                    <button type="button" class="close pull-right" ng-click="onCancelOrder()">&times;</button>
                                </div> -->
                            </div>

                            <p class="alert alert-danger col-sm-12" ng-show="err">{{errorMessage}}</p>
                            <div class="summary-tabs">
                                <div class="row mb-4">
                                    <div class="col-sm-6 col-6 pr-0">
                                        <div class="text-center">
                                            <h4>{{'text.pickup' | translate}}</h4>
                                            <div>
                                                <span class="text-captalize">{{localData.pickupDate.name}} {{localData.pickupDate.shortDate}}</span>
                                                <br>
                                                <span class="para2heading" ng-if="localData.pickupTime.leaveAtdoor != 'y'">
                                                    {{localData.pickupTime.time_from}}:00 {{'text.to' | translate}}
                                                    {{localData.pickupTime.time_to}}:00 </span>
                                                <span ng-if="localData.pickupTime.leaveAtdoor == 'y'"> {{'request_leave_at_door_short' | translate}} </span>

                                                <div class="mt-3"><a href="javascript:void(0)" class="round_button small-fixed-width-btn text-upper" ng-click="goToStep(0)">{{'text.change' | translate}}</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-6 pl-0">
                                        <div class="text-center">
                                            <h4>{{'text.delivery' | translate}}</h4>
                                            <div>
                                                <span class="text-captalize">{{localData.deliveryDate.name}} {{localData.deliveryDate.shortDate}}</span> <br>
                                                <span class="para2heading" ng-if="localData.pickupTime.leaveAtdoor != 'y'">
                                                    {{localData.pickupTime.time_from}}:00 {{'text.to' | translate}}
                                                    {{localData.pickupTime.time_to}}:00 </span>
                                                <span ng-if="localData.pickupTime.leaveAtdoor == 'y'"> {{'request_leave_at_door_short' | translate}} </span>
                                                <div class="mt-3"><a href="javascript:void(0)" class="round_button small-fixed-width-btn text-upper" ng-click="goToStep(2)">{{'text.change' | translate}}</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-box" ng-if="localData.pickupDate.price > 0 ||
                                                                (localData.pickupTime.price && localData.pickupTime.price > 0) ||
                                                                    localData.deliveryDate.price > 0 ||
                                                                        (localData.deliveryTime.price && localData.deliveryTime.price > 0)">
                                    <div class="row">
                                        <div class="col-sm-3 col-3 mt-3 text-center"><img src="<?php echo get_template_directory_uri(); ?>/images/dollar.png" width="45"></div>
                                        <div class="col-sm-9 col-9">
                                            <div class="item item-body orderlistbody">
                                                <strong>{{'request_pickup_extra_charges' | translate}}</strong><br>
                                                <div ng-show="localData.pickupDate.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> + {{localData.pickupDate.price | currency}} -
                                                    {{localData.pickupDate.name}} {{'text.pickup' | translate}}
                                                </div>


                                                <div ng-show="localData.pickupTime.price && localData.pickupTime.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> + {{localData.pickupTime.price  | currency}} - {{'request_pickup_fixed_time_pickup' | translate}}
                                                </div>

                                            </div>

                                            <div class="item item-body orderlistbody">

                                                <div ng-show="localData.deliveryDate.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> + {{localData.deliveryDate.price | currency}} - {{'request_pickup_next_day_delivery' | translate}}
                                                </div>


                                                <div ng-show="localData.deliveryTime.price && localData.deliveryTime.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> + {{localData.deliveryTime.price | currency}} - {{'request_pickup_fixed_time_drop' | translate}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div ng-include="'vault-card.html'"></div>

                                <div ng-include="'address-card.html'"></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="round_button action-btn pull-left" wz-previous="!showLoading && noValidation()">
                                        {{'text.previous' | translate}}
                                    </button>
                                    <button type="submit" class="round_button action-btn pull-right" wz-next="!showLoading && createOrder()" >
                                        {{'text.submit' | translate}}
                                    </button>
                                </div>
                            </div>
                        </wz-step>
                    </wizard>
                </div>
                <div class="other-content" ng-if="showLoading || orderCreationDone">
                    <div ng-include="'loader.html'" ng-if="showLoading"></div>

                    <div class="row text-center" ng-if="orderCreationDone">
                        <div class="col-sm-12">
                            <h2 class="text-success">
                                <i class="glyphicon glyphicon-ok-circle"></i>
                                <br>
                                <span>{{'request_pickup_order_success' | translate}}</span>
                            </h2>
                            <p>{{'request_pickup_order_success_message' | translate}}</p>
                            <p ng-if="!isUserLoggedIn">{{'request_pickup_order_success_information' | translate}}</p>
                            <div class="text-center">
                                <button type="button" class="round_button action-btn" data-toggle="modal" data-target="#summaryModal" ng-if="set_order_system == 'FULL'">{{'view_summary' | translate}}</button>
                                <button type="button" class="round_button action-btn" ng-click="closeOrder()">{{'text.close' | translate}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div ng-include="'copyright.html'"></div>

    
    <!-- New Address Modal -->
    <div class="modal fade" id="addressAddModal" role="dialog"  data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row title my-3 mx-0">
                        <div class="col-sm-10 col-10">
                            <h4 class="pull-left ml-2">{{'add_address' | translate}}</h4>
                        </div>
                        <div class="col-sm-2 col-2">
                            <button type="button" class="close pull-right mt-0" ng-click="closeModal('#addressAddModal')">&times;</button>
                        </div>
                    </div>
                    <form name="partial_{{Steps.address_detail}}" id="partial_{{Steps.address_detail}}" ng-validate="addressDetailsValidationOptions" class="m-4">
                        <div ng-include="'address-form.html'" ></div>

                        <div class="row">
                            <div class="col-sm-12">
                                <button class="round_button action-btn pull-right m-0" ng-disabled="loading" ng-click="!loading && performAction('SAVE_ADDRESS_DETAILS', false)">{{'text.save' | translate}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div ng-include="'loader.html'" ng-if="loading"></div>
            </div>
        </div>
    </div>
    <!-- End New Address Modal -->

    <!-- New Vault Modal -->
    <div class="modal fade" id="vaultAddModal" role="dialog"  data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row title my-3 mx-0">
                        <div class="col-sm-10 col-10">
                            <h4 class="pull-left ml-2">{{'add_vault' | translate}}</h4>
                        </div>

                        <div class="col-sm-2 col-2">
                            <button type="button" class="close pull-right mt-0" ng-click="closeModal('#vaultAddModal')">&times;</button>
                        </div>
                    </div>
                </div>
                <div ng-include="'vault-form.html'"></div>

                <div class="row">
                    <button class="round_button action-btn pull-right p-0 m-0 visiblity-none" id="loadVaults" ng-click="performAction('GET_PAYMENT_DETAILS')">{{'text.next' | translate}}</button>
                    <div class="col-sm-12 text-center mb-3">
                        <a href="javascript:void(0)" ng-click="reloadPaymentWindow()">{{'text.reload_Payment_window' | translate}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End New Vault Modal -->

    <!-- Change Address Modal -->
    <div class="modal fade" id="addressChangeModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row title my-3 mx-0">
                        <div class="col-sm-10 col-10">
                            <h4 class="pull-left ml-2">{{'change_address' | translate}}</h4>
                        </div>

                        <div class="col-sm-2 col-2">
                            <button type="button" class="close pull-right mt-0" ng-click="closeModal('#addressChangeModal')">&times;</button>
                        </div>
                    </div>
                    <div class="cards-container m-4">
                        <div ng-repeat="getAddress in AllAddresses" ng-click="changeAddress(getAddress)">
                            <div ng-include="'address-card.html'"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="round_button action-btn m-0" ng-click="openAddAddressModal()">{{'text.add' | translate}}</button>
                </div>
                <div ng-include="'loader.html'" ng-if="loading"></div>
            </div>
        </div>
    </div>
    <!-- End Change Address Modal -->

    <!-- Change Vault Modal -->
    <div class="modal fade" id="vaultChangeModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row title my-3 mx-0">
                        <div class="col-sm-10 col-10">
                            <h4 class="pull-left ml-2">{{'change_vault' | translate}}</h4>
                        </div>

                        <div class="col-sm-2 col-2">
                            <button type="button" class="close pull-right mt-0" ng-click="closeModal('#vaultChangeModal')">&times;</button>
                        </div>
                    </div>
                    <div class="cards-container m-4">
                        <div ng-repeat="getPayment in AllPayments" ng-click="changeVault(getPayment)">
                            <div ng-include="'vault-card.html'"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer text-center">
                    <button type="button" class="round_button action-btn m-0" ng-click="openAddVaultModal()">{{'text.add' | translate}}</button>
                </div>
                <div ng-include="'loader.html'" ng-if="loading"></div>
            </div>
        </div>
    </div>
    <!-- End Change Vault Modal -->

    <!-- Summary Modal -->
    <div class="modal fade" id="summaryModal" role="dialog"  data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="text-center mb-3">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo-top.png" class="popup-top-logo img-responsive" />
            </div>
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row title my-3 mx-0">
                        <div class="col-sm-10 col-10">
                            <h4 class="pull-left">{{'request_pickup_order_summary' | translate}}</h4>
                        </div>
                        <div class="col-sm-2 col-2">
                            <button type="button" class="close pull-right" ng-click="closeModal('#summaryModal')">&times;</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="summary-tabs" ng-if="orderSummary">
                                <div class="row mb-4">
                                    <div class="col-sm-6 col-6 pr-0">
                                        <div class="text-center">
                                            <h4>{{'text.pickup' | translate}}</h4>
                                            <div>
                                                <span class="text-captalize">{{orderSummary.pickupDate.name}} {{orderSummary.pickupDate.shortDate}}</span>
                                                <br>
                                                <span class="para2heading" ng-if="orderSummary.pickupTime.leaveAtdoor != 'y'">
                                                    {{orderSummary.pickupTime.time_from}}:00 {{'text.to' | translate}}
                                                    {{orderSummary.pickupTime.time_to}}:00 </span>
                                                <span ng-if="orderSummary.pickupTime.leaveAtdoor == 'y'"> {{'request_leave_at_door_short' | translate}} </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-6 pl-0">
                                        <div class="text-center">
                                            <h4>{{'text.delivery' | translate}}</h4>
                                            <div>
                                                <span class="text-captalize">{{orderSummary.deliveryDate.name}} {{orderSummary.deliveryDate.shortDate}}</span> <br>
                                                <span class="para2heading" ng-if="orderSummary.pickupTime.leaveAtdoor != 'y'">
                                                    {{orderSummary.pickupTime.time_from}}:00 {{'text.to' | translate}}
                                                    {{orderSummary.pickupTime.time_to}}:00 </span>
                                                <span ng-if="orderSummary.pickupTime.leaveAtdoor == 'y'"> {{'request_leave_at_door_short' | translate}} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-box" ng-if="orderSummary.pickupDate.price > 0 ||
                                                                (orderSummary.pickupTime.price && orderSummary.pickupTime.price > 0) ||
                                                                    orderSummary.deliveryDate.price > 0 ||
                                                                        (orderSummary.deliveryTime.price && orderSummary.deliveryTime.price > 0)">
                                    <div class="row">
                                        <div class="col-sm-3 col-3 mt-3 text-center"><img src="<?php echo get_template_directory_uri(); ?>/images/dollar.png" width="45"></div>
                                        <div class="col-sm-9 col-9">
                                            <div class="item item-body orderlistbody">
                                                <strong>{{'request_pickup_extra_charges' | translate}}</strong><br>
                                                <div ng-show="orderSummary.pickupDate.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> + {{orderSummary.pickupDate.price | currency}} -
                                                    {{orderSummary.pickupDate.name}} {{'text.pickup' | translate}}
                                                </div>


                                                <div ng-show="orderSummary.pickupTime.price && orderSummary.pickupTime.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> + {{orderSummary.pickupTime.price  | currency}} - {{'request_pickup_fixed_time_pickup' | translate}}
                                                </div>

                                            </div>

                                            <div class="item item-body orderlistbody">

                                                <div ng-show="orderSummary.deliveryDate.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> + {{orderSummary.deliveryDate.price | currency}} - {{'request_pickup_next_day_delivery' | translate}}
                                                </div>


                                                <div ng-show="orderSummary.deliveryTime.price && orderSummary.deliveryTime.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> + {{orderSummary.deliveryTime.price | currency}} - {{'request_pickup_fixed_time_drop' | translate}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-sm-3 col-3 mt-4 text-center"><img src="<?php echo get_template_directory_uri(); ?>/images/credit-card.png" width="45"></div>
                                        <div class="col-sm-9 col-9">
                                            <strong>{{'payement_details_text' | translate}}</strong><br>

                                            <div ng-if="getPayment.payment_type">
                                                <span class="borderdotdot" ng-bind="displayCardName(getPayment.payment_type)"> </span> 
                                            </div>
                                            <div  ng-if="getPayment.number">
                                                {{'request_pikcup_card_end_with' | translate}}:- <span class="borderdotdot"> {{getPayment.number | limitTo:-4}} </span>
                                            </div>
                                            <div>
                                                {{'text.expiry' | translate}} :- <span class="borderdotdot">  {{getPayment.expiry_month}}/{{getPayment.expiry_date}} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-sm-3 col-3 mt-1 text-center"><img src="<?php echo get_template_directory_uri(); ?>/images/address.png" width="45"></div>
                                        <div class="col-sm-9 col-9">
                                        <strong>{{'address_details_text' | translate}}</strong><br>
                                            <span ng-if="getAddress != null">
                                                <div class="borderdotdot">{{getAddress.street_name}}, {{getAddress.floor}}</div>
                                                <div>{{'address_details.unit_number' | translate}} :- {{getAddress.unit_number}}</div>
                                                <div>{{'address_details.po_box' | translate}} :- {{getAddress.pobox}}</div>

                                                <!-- <div ng-bind="displayCityName(address_details.city_id)"></div> -->
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div ng-include="'copyright.html'"></div>
    </div>
    <!-- End Summary Modal -->

    <!-- No Services Modal -->
    <div class="modal fade" id="noServiceModal" role="dialog"  data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row title my-3 mx-0">
                        <div class="col-sm-10 col-10">
                            <h4 class="pull-left">{{'request_pickup' | translate}}</h4>
                        </div>
                        <div class="col-sm-2 col-2">
                            <button type="button" class="close pull-right" ng-click="closeModal('#noServiceModal')">&times;</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                        <p>Sorry we are not yet serving your city but will let you know as soon as we get there.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End No Services Modal -->

    <!--Vault Card Template-->
    <script type="text/ng-template" id="vault-card.html">
        <div class="card-box vault-card">
            <div class="row">
                <div class="col-sm-3 col-3 text-center" ng-class="$index > -1?'mt-2':'mt-4'"><img src="<?php echo get_template_directory_uri(); ?>/images/credit-card.png" width="45"></div>
                <div ng-class="$index > -1?'col-sm-9 col-9':'col-sm-6 col-6'">
                    <div ng-hide="$index > -1"><strong>{{'payement_details_text' | translate}}</strong></div>
                    <div ng-if="getPayment.payment_type">
                        <span class="borderdotdot" ng-bind="displayCardName(getPayment.payment_type)"> </span> <span ng-if="getPayment.as_default == 1" class="text-success"><i class="fa fa-check" ng-class="$index > -1?'large-check':''"></i></span>
                    </div>
                    <div  ng-if="getPayment.number">
                        {{'request_pikcup_card_end_with' | translate}} :- <span class="borderdotdot"> {{getPayment.number | limitTo:-4}} </span>
                    </div>
                    <div>
                        {{'text.expiry' | translate}} :- <span class="borderdotdot"> {{getPayment.expiry_month}}/{{getPayment.expiry_date}} </span>
                    </div>
                </div>

                <div class="col-sm-3 p-0 col-3" ng-hide="$index > -1">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#vaultChangeModal" class="round_button small-fixed-width-btn mt-3 text-upper" ng-if="AllPayments.length > 1">{{'text.change' | translate}}</a>
                    <a href="javascript:void(0)" class="round_button small-fixed-width-btn mt-3 text-upper" ng-click="openAddVaultModal()" ng-if="AllPayments.length == 1">{{'text.change' | translate}}</a>
                </div>
            </div>
        </div>
    </script>

    <!--Address Card Template-->
    <script type="text/ng-template" id="address-card.html">
        <div class="card-box address-card">
            <div class="row">
                <div class="col-sm-3 col-3 text-center" ng-class="$index > -1?'mt-1':'mt-1'"><img src="<?php echo get_template_directory_uri(); ?>/images/address.png" width="45"></div>
                <div ng-class="$index > -1?'col-sm-9 col-9':'col-sm-6 col-6'">
                    <div ng-hide="$index > -1"><strong>{{'address_details_text' | translate}}</strong></div>
                    <span ng-if="getAddress != null">
                        <div class="borderdotdot">{{getAddress.street_name}}, {{getAddress.floor}} <span ng-if="getAddress.as_default == 1" class="text-success"><i class="fa fa-check"  ng-class="$index > -1?'large-check':''"></i></span></div>
                        <div>{{'address_details.unit_number' | translate}} :- {{getAddress.unit_number}}</div>
                        <div>{{'address_details.po_box' | translate}} :- {{getAddress.pobox}}</div>
                        <!-- <div ng-bind="displayCityName(address_details.city_id)"></div> -->
                    </span>
                </div>
                <div class="col-sm-3 col-3 p-0" ng-hide="$index > -1">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#addressChangeModal" data-toggle="modal" class="round_button mt-3 small-fixed-width-btn text-upper" ng-if="AllAddresses.length > 1">{{'text.change' | translate}}</a>
                    <a href="javascript:void(0)" class="round_button small-fixed-width-btn text-upper mt-3" ng-click="openAddAddressModal()" ng-if="AllAddresses.length == 1">{{'text.change' | translate}}</a>
                </div>
            </div>
        </div>
    </script>

    <!--Address Form Template-->
    <script type="text/ng-template" id="address-form.html">
        <div class="row">
            <div class="col-sm-12">
                <p class="alert alert-danger" ng-show="addressErr">{{addressErrorMessage}}</p>
                
                <div class="form-group">
                    <label class="font-weight-bold">{{'address_details.street_name' | translate}}</label>
                    <input type="text" name="street_name" class="form-control" ng-disabled="loading" ng-model="addressDetails.street_name" autofocus />
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">{{'address_details.floor' | translate}}</label>
                    <input type="text" name="floor" class="form-control" ng-disabled="loading" ng-model="addressDetails.floor" />
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">{{'address_details.unit_number' | translate}}</label>
                    <input type="text" name="unit_number" class="form-control" ng-disabled="loading" ng-model="addressDetails.unit_number" />
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">{{'address_details.po_box' | translate}}</label>
                    <input type="text" name="pobox" class="form-control" ng-disabled="loading" ng-model="addressDetails.pobox" />
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">{{'address_details.city' | translate}}</label>
                    <select ng-model="addressDetails.city_id" ng-disabled="loading" name="city" class="form-control" required>
                        <option value="">{{'text.select' | translate}} {{'address_details.city' | translate}}</option>
                        <option ng-repeat="value in cityData"  value="{{value.id}}">
                            {{value.title}}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </script>

    <!--Vault Form Template-->
    <script type="text/ng-template" id="vault-form.html">
        <p class="alert alert-danger" ng-show="paymentErr">{{paymentErrorMessage}}</p>
        <div class="paymentIframeContainer"></div>
    </script>
</div>
<!-- End Pickup -->

<Script type="text/ng-template" id="loader.html">
    <div class="loader-container">
        <div class="loader"></div>
    </div>
</Script>

<script type="text/ng-template" id="copyright.html">
    <div class="modal-copyright text-center">
        <a href="javascript:void(0)" data-toggle="modal" data-target="#pricingModal">{{'menu_link_pricing' | translate}}</a>
        <p class="copyright mt-1">EazyWash &copy; {{currentYear}}</p>
    </div>
</script>

<!-- Forgot passowrd Modal -->
<div class="modal fade" id="forgotPassword" role="dialog" ng-controller="ForgetCtrl">
    <div class="modal-dialog">

        <form name="ForgotPasswordForm" ng-submit="!loading && forgotpassowrd(ForgotPasswordForm)" autocomplete="off" ng-validate="forgotPasswordValidationOptions">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{'forgot_password' | translate}}</h4>
                    <button type="button" class="close mt-1" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div ng-if="messageObj" ng-class="messageObj.class">{{messageObj.message}}</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="email" id="fw-email" ng-model="form.email" class="form-control" placeholder="{{'basic_details.email' | translate}}" ng-disabled="loading" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="forgot-pwd" ng-disabled="loading">{{'text.submit' | translate}}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" ng-disabled="loading">{{'text.cancel' | translate}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end of Forgot Modal Popup -->

<!-- Pricing Modal -->
<div class="modal fade" id="pricingModal" role="dialog" ng-controller="PricingCtrl">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{'menu_link_pricing' | translate}}</h4>
                <button type="button" class="close mt-1" ng-click="closeModal('#pricingModal')">&times;</button>
            </div>
            <div class="modal-body p-4 mt-6">
                <!-- <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th>{{'basic_details.name' | translate}}</th>
                                <th>{{'text.type' | translate}}</th>
                                <th>{{'text.price' | translate}}</th>
                            </tr>
                            <tr ng-repeat="price in prices">
                                <td>{{price.title}}</td>
                                <td>{{price.type}}</td>
                                <td>{{price.price | currency}}</td>
                            </tr>
                        </table>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-sm-4 price" ng-repeat="(key, price) in prices" ng-class="{'price-active': $odd}">
                        <div class="price-logo text-center">
                            <img class="img-fluid" ng-src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/price-top{{$odd?'-active':''}}.png" alt="price">
                            <img ng-src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/upper.png" class="category upper" alt="upper" width="50" ng-if="key.toLowerCase().indexOf('upper') > -1" /> 
                            <img ng-src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/lower.png" class="category lower" alt="lower" width="50" ng-if="key.toLowerCase().indexOf('lower') > -1" /> 
                            <img ng-src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/non-wearable.png" class="category non-wearable" width="50" alt="non wearable" ng-if="key.toLowerCase().indexOf('non') > -1" />
                        </div>
                        <div class="price-heading mt-2 text-center">
                            <h3>{{key}}</h3>
                        </div>
                        <div class="price-text mt-3">
                            <p ng-repeat="item in price"><label class="pull-left">{{item.title}}</label> <strong class="pull-right text-right">{{item.price | currency}}</strong></p>
                            <!-- <a class="cust-button mt-3" href="#">CHECK</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>