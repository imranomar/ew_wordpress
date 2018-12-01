<!-- Login Form -->
<div class="modal fade" id="loginForm" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{'login_form_title' | translate}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</buttwz-stepon>
            </div>
            <div class="modal-body">
                <!-- Centered Tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="javascript:void(0)" data-target="#login">{{'text.login' | translate}}</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="javascript:void(0)" class="nav-link" data-target="#register">{{'text.register' | translate}}</a></li>
                </ul>
                
                <div class="tab-content">
                    <div id="login" class="tab-pane active" ng-controller="LoginCtrl">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="alert alert-danger" ng-show="err">{{errorMessage}}</p>
                                <form name="LoginForm" ng-submit="!loading && loginsubmit(LoginForm)" autocomplete="off" ng-validate="loginValidationOptions">
                                    <div class="form-group">
                                        <input type="text" name="email" ng-model="logindata.email" tabindex="1" class="form-control" placeholder="{{'text.user_or_email' | translate}}" ng-disabled="loading" />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" ng-model="logindata.password" class="form-control" placeholder="{{'basic_details.password' | translate}}" ng-disabled="loading" />
                                    </div>
                                    <div class="form-group">
                                    <div class="row">
                                        <a class="col-sm-12 text-center" href="javascript:void(0)" onclick="openForgotPasswordModal()">
                                            <span class="hidden-xs">Forgot Password</span>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-primary">{{'text.login' | translate}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="register" class="tab-pane fade" ng-controller="SignupCtrl">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="alert alert-danger" ng-show="err">{{errorMessage}}</p>
                                <p class="alert alert-danger" ng-show="required"> {{field}} !!!</p>

                                <form name="RegisterForm" autocomplete="off" ng-submit="!loading && signupsubmitform(RegisterForm)" ng-validate="basicDetailsValidationOptions">
                                    <div class="form-group">
                                        <input type="text" name="fullname" class="form-control" placeholder="{{'basic_details.name' | translate}}" ng-model="signupdata.name" ng-disabled="loading" />
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="{{'basic_details.email' | translate}}" ng-model="signupdata.email" ng-disabled="loading" />
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control" placeholder="{{'basic_details.phone' | translate}}" ng-model="signupdata.phone" ng-disabled="loading" />
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="{{'basic_details.password' | translate}}" ng-model="signupdata.password" ng-disabled="loading" />
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-primary" ng-disabled="loading">{{'text.register_now' | translate}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 text-center text-upper mb-3">
                            {{'text.or' | translate}}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <a href="javascript:void(0)" onclick="loginWithFacebook()" class="col-sm-12 text-center">
                            <span class="hidden-xs">Facebook</span>
                        </a>
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
                <button type="button" class="close" data-dismiss="modal" ng-disabled="loading">&times;</button>
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
<div class="modal fade" id="requestPickupModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" ng-controller="OrdersummaryCtrl">
            <div class="modal-header">
                <h4 class="modal-title">{{'request_pickup' | translate}}</h4>
                <div class="div_close_icon" ng-click=`"onCancelOrder()">
                    <span class="fa fa-times"></span>
                </div>
            </div>
            <div class="modal-body">
                <div class="myorder Deliverydate finaldate" ng-if="!showLoading && !orderCreationDone">
                    <wizard on-finish="finished()" indicators-position="top" name="requestPickupWizard" edit-mode="true" ng-init="initializeWizard()">
                        <wz-step wz-title="1" wz-heading-title="{{Steps.pickup_date}}" canenter="validateStep">
                            <div class="row my-3">
                                <div class="col-sm-12">
                                    <h4>{{'request_pickup_date' | translate}} :-)</h4>
                                </div>
                            </div>
                            <div class="row" ng-repeat="value in pickupDateList" ng-hide="!showAllpickupDateList && $index > 3" wz-next="performAction('SAVE_PICKUP_DATE', value)"
                                ng-class="{
                                            'today-div': value.name == 'Today',
                                            'tomorrow-div': value.name == 'Tomorrow',
                                        }">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h5 class="text-capitalize">{{value.name}}</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 lighter-text">{{value.shortDate}} </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <span class="round_button pull-right" ng-if="value.price"> $ {{value.price}}</span>
                                                <span class="round_button pull-right" ng-if="!value.price">{{'Free' | translate}}</span>
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
                                                <span class="round_button pull-right" ng-if="value.price">$ {{value.price}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="2" wz-heading-title="{{Steps.pickup_time}}" canenter="validateStep">
                            <div class="row my-3">
                                <div class="col-sm-12">
                                    <h4>{{'request_pickup_time' | translate}}</h4>
                                </div>
                            </div>
                            <div id="div_slots">
                                <div class="row" ng-repeat="value in TimeSlots" ng-class="{'active': localData.pickupTime && localData.pickupTime.id == value.id }">
                                    <div class="col-sm-12">
                                        <div class="card-box" wz-next="performAction('SELECT_PICKUP_TIME', value)" ng-class="{'fade': localData.pickupTime.leaveAtdoor}">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row">
                                                        <div class="col-sm-12"><img width="70" ng-src="<?php echo get_template_directory_uri(); ?>/images/{{value.time_from}}.png"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- we do not have one hour slot option now -->
                                                            <!-- <span ng-if="value.type == 1">FLEXIBLE </span>
                                                            <span ng-if="value.type == 2"> ONE HOUR SLOT </span> -->
                                                            <h6 class="text-upper"> {{'text.between' | translate}} </h6>
                                                            <h5> {{value.time_from}}:00 to {{value.time_to}}:00 </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="round_button pull-right">{{value.price > 0 ? '$ '+ value.price : 'Free'}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row">
                                    <div class="col-sm-12 text-center text-upper mb-3">{{'text.or' | translate}}</div>
                                </div>

                                <div class="row" ng-class="{'active': localData.pickupTime && localData.pickupTime.leaveAtdoor == 'y' }">
                                    <div class="col-sm-12">
                                        <div class='card-box' wz-next="performAction('SELECT_PICKUP_AT_DOOR', '')">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <div class="item ">
                                                        <label class="container" for="pickAtDoor"><h5> {{'request_leave_at_door' | translate}} </h5>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="round_button pull-right"> {{'text.free' | translate}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class=" round_button  pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    </div>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="3" wz-heading-title="{{Steps.drop_date}}" canenter="validateStep">
                            <div class="row my-3">
                                <div class="col-sm-12">
                                    <h4> {{'request_drop_date' | translate}}</h4>
                                </div>
                            </div>

                            <div class="row" ng-repeat="value in deliveryDateList" ng-hide="!showAlldeliveryDateList && $index > 4"
                                wz-next="performAction('SAVE_DELIVERY_DATE', value)" ng-class="{
                                                    'tomorrow-div': value.name == 'Tomorrow',
                                                    'day-after-div': value.name == 'day after',
                                                }">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h5 class='text-capitalize'>{{value.name}}</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">{{value.shortDate}} </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <span class="round_button" ng-if="value.price"> $ {{value.price}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" ng-if="!showAlldeliveryDateList">
                                <div class="col-sm-12" ng-click="loadMoreDeliveryDates()">
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
                                                <span class="round_button" ng-if="value.price">$ {{value.price}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="round_button pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="4" wz-heading-title="{{Steps.drop_time}}" canenter="validateStep">
                            <div class="row my-3">
                                <div class="col-sm-12">
                                    <div class='left-align'>
                                        <h4>{{'request_drop_time' | translate}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div id="div_slots">
                                <div class="row" ng-repeat="value in TimeSlots" ng-class="{'active': localData.deliveryTime && localData.deliveryTime.id == value.id }">
                                    <div class="col-sm-12">
                                        <div class="card-box" wz-next="performAction('SELECT_DELIVERY_TIME', value)">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row">
                                                        <div class="col-sm-12"><img width="70" ng-src="<?php echo get_template_directory_uri(); ?>/images/{{value.time_from}}.png"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h6 class="text-upper"> {{'text.between' | translate}} </h6>
                                                            <h5 class="text-upper"> {{value.time_from}}:00 {{'text.to' | translate}} {{value.time_to}}:00 </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="round_button">{{value.price > 0 ? '$ '+value.price : 'Free'}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row">
                                    <div class="col-sm-12 text-center text-upper mb-3">{{'text.or' | translate}}</div>
                                </div>

                                <div class="row" ng-class="{'active': localData.deliveryTime && localData.deliveryTime.leaveAtdoor == 'y' }">
                                    <div class="col-sm-12">
                                        <div class="card-box" wz-next="performAction('SELECT_DELIVERY_AT_DOOR', '')">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <div class="item ">
                                                        <label class="container" for="deliveryDropAtDoor">{{'request_leave_at_door' | translate}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="round_button">{{'text.free' | translate}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="round_button pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    </div>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="5" wz-heading-title="{{Steps.user_detail}}" wz-disabled="{{isUserLoggedIn}}" canenter="validateStep">
                            <div class="row my-3">
                                <div class="col-sm-12">
                                    <div class='left-align'>
                                        <h4>{{'request_pickup_enter_basic_details' | translate}}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="alert alert-danger" ng-show="userErr">{{userErrorMessage}}</p>
                                    <form name="{{Steps.user_detail}}" id="{{Steps.user_detail}}" ng-validate="basicDetailsValidationOptions">
                                        <div class="form-group">
                                            <input type="text" name="fullname" class="form-control" placeholder="{{'basic_details.name' | translate}}" ng-model="localData.userDetails.full_name" ng-disabled="loading" />
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="{{'basic_details.email' | translate}}" ng-model="localData.userDetails.email" ng-disabled="loading" />
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="text" name="phone" class="form-control" placeholder="{{'basic_details.phone' | translate}}" ng-model="localData.userDetails.phone" ng-disabled="loading" />
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="{{'basic_details.password' | translate}}" ng-model="localData.userDetails.password" ng-disabled="loading" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="wizard-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    <button class="wizard-btn pull-right" ng-click="performAction('SAVE_USER_DETAILS')">{{'text.next' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="{{isUserLoggedIn && showAddressDetailStep?'5':'6'}}" wz-heading-title="{{Steps.address_detail}}" wz-disabled="{{isUserLoggedIn && showAddressDetailStep == false}}" canenter="validateStep">
                            <div class="row my-3">
                                <div class="col-sm-12">
                                    <div class='left-align'>
                                        <h4>{{'request_pickup_enter_address_details' | translate}}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="alert alert-danger" ng-show="addressErr">{{addressErrorMessage}}</p>
                                    <form name="{{Steps.address_detail}}" id="{{Steps.address_detail}}" ng-validate="addressDetailsValidationOptions">  
                                        <div class="form-group">
                                            <input type="text" name="street_name" class="form-control" placeholder="{{'address_details.street_name' | translate}}" ng-model="localData.addressDetails.street_name" />
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="text" name="floor" class="form-control" placeholder="{{'address_details.floor' | translate}}" ng-model="localData.addressDetails.floor" />
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="pobox" class="form-control" placeholder="{{'address_details.po_box' | translate}}"" ng-model="localData.addressDetails.pobox" />
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="text" name="unit_number" class="form-control" placeholder="{{'address_details.unit_number' | translate}}"" ng-model="localData.addressDetails.unit_number" />
                                        </div>

                                        <div class="form-group">
                                            <select ng-model="localData.addressDetails.city_id" name="city" class="form-control">
                                                <option value="">{{'text.select' | translate}} {{'address_details.city' | translate}}</option>
                                                <option ng-repeat="value in cityData" value="{{value.id}}">
                                                    {{value.title}}
                                                </option>                                 
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="wizard-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    <button class="wizard-btn pull-right" ng-click="performAction('SAVE_ADDRESS_DETAILS')">{{'text.next' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="{{isUserLoggedIn && showPaymentDetailStep?(showAddressDetailStep?'6':'5'):'7'}}" wz-heading-title="{{Steps.payment_detail}}" wz-disabled="{{isUserLoggedIn && showPaymentDetailStep == false}}" canenter="validateStep">
                            <div class="row my-3">
                                <div class="col-sm-12">
                                    <div class='left-align'>
                                        <h4>{{'request_pickup_enter_payemnt_details' | translate}}</h4>
                                    </div>
                                </div>
                            </div>
                            <p class="alert alert-danger" ng-show="paymentErr">{{paymentErrorMessage}}</p>
                            <div class="paymentIframeContainer"></div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="wizard-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    <button class="wizard-btn pull-right" id="orderLoadVaults" ng-click="performAction('GET_PAYMENT_DETAILS')">{{'text.next' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>
                                                    
                        <wz-step wz-title="{{lastStepNumber}}" wz-heading-title="{{Steps.order_summary}}" canenter="validateStep">
                            <div class="row my-3">
                                <div class="col-sm-12">
                                    <div class='left-align'>
                                        <h4>{{'request_pickup_order_summary' | translate}}</h4>
                                    </div>
                                </div>
                            </div>
                            <p class="alert alert-danger col-sm-12" ng-show="err">{{errorMessage}}</p>
                            <div class="summary-tabs">
                                <div class="row mb-4">
                                    <div class="col-sm-6 pr-0">
                                        <div class="text-center">
                                            <h4 style="background-color:#E1F5FE;;padding: 10px;">{{'text.pickup' | translate}}</h4>
                                            <div>
                                                {{localData.pickupDate.name}} {{localData.pickupDate.shortDate}}
                                                <br>
                                                <span class="para2heading" ng-if="localData.pickupTime.leaveAtdoor != 'y'">
                                                    {{localData.pickupTime.time_from}}:00 {{'text.to' | translate}}
                                                    {{localData.pickupTime.time_to}}:00 </span>
                                                <span ng-if="localData.pickupTime.leaveAtdoor == 'y'"> {{'request_leave_at_door_short' | translate}} </span>

                                                <div class="mt-3"><a href="javascript:void(0)" class="round_button text-upper" ng-click="goToStep(0)">Change</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pl-0">
                                        <div class="text-center">
                                            <h4 style="background-color:#E1F5FE;;padding: 10px;">{{'text.delivery' | translate}}</h4>
                                            <div>
                                                {{localData.deliveryDate.name}} {{localData.deliveryDate.shortDate}} <br>
                                                <span class="para2heading" ng-if="localData.pickupTime.leaveAtdoor != 'y'">
                                                    {{localData.pickupTime.time_from}}:00 {{'text.to' | translate}}
                                                    {{localData.pickupTime.time_to}}:00 </span>
                                                <span ng-if="localData.pickupTime.leaveAtdoor == 'y'"> {{'request_leave_at_door_short' | translate}} </span>
                                                <div class="mt-3"><a href="javascript:void(0)" class="round_button text-upper" ng-click="goToStep(2)">Change</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-sm-3"><img src="<?php echo get_template_directory_uri(); ?>/images/dollar.png" width="100%"></div>
                                        <div class="col-sm-9">
                                            <div class="item item-body orderlistbody">
                                                <strong>{{'request_pickup_extra_charges' | translate}}</strong><br>
                                                <div ng-show="localData.pickupDate.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> ${{localData.pickupDate.price}} -
                                                    {{localData.pickupDate.name}} Pickup
                                                </div>


                                                <div ng-show="localData.pickupTime.price && localData.pickupTime.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> ${{localData.pickupTime.price}} - {{'request_pickup_fixed_time_pickup' | translate}}
                                                </div>

                                            </div>

                                            <div class="item item-body orderlistbody">

                                                <div ng-show="localData.deliveryDate.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> ${{localData.deliveryDate.price}} - {{'request_pickup_next_day_delivery' | translate}}
                                                </div>


                                                <div ng-show="localData.deliveryTime.price && localData.deliveryTime.price > 0">
                                                    <i class="glyphicon glyphicon-plus"> </i> ${{localData.deliveryTime.price}} - {{'request_pickup_fixed_time_drop' | translate}}
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
                                    <button class="wizard-btn pull-left" wz-previous="!showLoading && noValidation()">
                                        {{'text.previous' | translate}}
                                    </button>
                                    <button type="submit" class="wizard-btn pull-right" wz-next="!showLoading && createOrder()" >
                                        {{'text.submit' | translate}}
                                    </button>
                                </div>
                            </div>

                            <!-- Change Address Modal -->
                            <div class="modal" id="addressChangeModal" role="dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Change Address</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div ng-repeat="getAddress in AllAddresses" ng-click="changeAddress(getAddress)">
                                            <div ng-include="'address-card.html'"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Change Address Modal -->

                             <!-- Change Vault Modal -->
                             <div class="modal" id="vaultChangeModal" role="dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Change Vault</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div ng-repeat="getPayment in AllPayments" ng-click="changeVault(getPayment)">
                                            <div ng-include="'vault-card.html'"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Change Vault Modal -->

                            <!--Vault Card Template-->
                            <script type="text/ng-template" id="vault-card.html">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-sm-3"><img src="<?php echo get_template_directory_uri(); ?>/images/mastercard.png" width="100%"></div>
                                        <div class="col-sm-6">
                                            <div ng-if="getPayment.payment_type">
                                                <span class="borderdotdot" ng-bind="displayCardName(getPayment.payment_type)"> </span> <span ng-if="getPayment.as_default == 1" class="text-success"><i class="fa fa-check"></i></span>
                                            </div>
                                            <div  ng-if="getPayment.number">
                                                {{'request_pikcup_card_end_with' | translate}}: -<span class="borderdotdot"> {{getPayment.number | limitTo:-4}} </span>
                                            </div>
                                            <div  ng-if="getPayment.expiry_date">
                                                {{'request_pickup_card_expiry_date' | translate}} : - <span class="borderdotdot"> {{getPayment.expiry_date}} </span>
                                            </div>
                                            <div  ng-if="getPayment.expiry_month">
                                                {{'request_pickup_card_expiry_month' | translate}} : - <span class="borderdotdot"> {{getPayment.expiry_month}} </span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3" ng-hide="$index > -1" ng-if="AllPayments.length > 1">
                                            <a href="#vaultChangeModal" class="modal-trigger round_button text-upper">Change</a>
                                        </div>
                                    </div>
                                </div>               
                            </script>

                            <!--Address Card Template-->
                            <script type="text/ng-template" id="address-card.html">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-sm-3"><img src="<?php echo get_template_directory_uri(); ?>/images/address.png" width="100%"></div>
                                        <div class="col-sm-6">
                                            <span ng-if="getAddress != null">
                                                <div class="borderdotdot">{{getAddress.street_name}} <span ng-if="getAddress.as_default == 1" class="text-success"><i class="fa fa-check"></i></span></div>
                                                <div>{{'address_details.floor' | translate}} :{{getAddress.floor}}</div>
                                                <div>{{'address_details.unit_number' | translate}} : {{getAddress.unit_number}}</div>
                                            </span>
                                        </div>
                                        <div class="col-sm-3" ng-hide="$index > -1" ng-if="AllAddresses.length > 1">
                                            <a href="#addressChangeModal" data-toggle="modal" class="modal-trigger round_button text-upper">Change</a>
                                        </div>
                                    </div>
                                </div>
                            </script>
                        </wz-step>
                    </wizard>
                </div>
                <div class="other-content" ng-if="showLoading || orderCreationDone">
                    <div class="loader" ng-if="showLoading"></div>
                    <div class="row text-center" ng-if="orderCreationDone">
                        <div class="col-sm-6 col-sm-offset-3">
                            <h2 class="text-success">
                                <i class="glyphicon glyphicon-ok-circle"></i>
                                <br>
                                <span>{{'request_pickup_order_success' | translate}}</span>
                            </h2>
                            <p>{{'request_pickup_order_success_message' | translate}}</p>
                            <p ng-if="!isUserLoggedIn">{{'request_pickup_order_success_information' | translate}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Pickup -->

<!-- Forgot passowrd Modal -->
<div class="modal fade" id="forgotPassword" role="dialog" ng-controller="ForgetCtrl">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form name="ForgotPasswordForm" ng-submit="!loading && forgotpassowrd(ForgotPasswordForm)" autocomplete="off" ng-validate="forgotPasswordValidationOptions">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Forgot Password</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div ng-if="messageObj" ng-class="messageObj.class">{{messageObj.message}}</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="email" ng-model="form.email" class="form-control" placeholder="{{'basic_details.email' | translate}}" ng-disabled="loading" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" ng-disabled="loading">{{'text.submit' | translate}}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" ng-disabled="loading">{{'text.cancel' | translate}}</button>
                </div>
            </div>
        </form>
    </div>
</div>