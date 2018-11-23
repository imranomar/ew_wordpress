<!-- Login Form -->
<div class="modal fade" id="loginForm" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{'login_form_title' | translate}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                                <p class="alert alert-danger" ng-show="required"> {{field}} !!!</p>
                                <form ng-submit="!loading && loginsubmit()" autocomplete="off">
                                    <div class="form-group">
                                        <input type="text" name="email" ng-model="logindata.email" tabindex="1" class="form-control" placeholder="{{'text.user_or_email' | translate}}" ng-disabled="loading" />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" ng-model="logindata.password" class="form-control" placeholder="{{'basic_details.password' | translate}}" ng-disabled="loading" />
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

                                <form method="post" role="form" autocomplete="off" ng-submit="!loading && signupsubmitform()">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="{{'basic_details.name' | translate}}" ng-model="signupdata.name" ng-disabled="loading" />
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
                        <div class="col-sm-12 text-center text-upper">
                            {{'text.or' | translate}}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <a href="javascript:void(0)" onclick="loginWithFacebook()" class="btn btn-lg btn-block omb_btn-facebook">
                            <i class="fa fa-facebook visible-xs"></i>
                            <span class="hidden-xs">Facebook</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{'text.close' | translate}}</button>
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
<div class="modal fade" id="requestPickupModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" ng-controller="OrdersummaryCtrl">
            <div class="modal-header">
                <h4 class="modal-title">{{'request_pickup' | translate}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="myorder Deliverydate finaldate" ng-if="!showLoading && !orderCreationDone">
                    <wizard on-finish="finished()" indicators-position="top" name="requestPickupWizard" edit-mode="true" ng-init="initializeWizard()">
                        <wz-step wz-title="1" wz-heading-title="{{Steps.pickup_date}}" canenter="validateStep">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h2>{{'request_pickup_date' | translate}}</h2>
                                </div>
                                <div class="col-sm-4">
                                    <div class='text-right'>
                                        <div class="div_close_icon" wz-cancel="onCancelOrder()">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-repeat="value in pickupDateList" ng-hide="!showAllpickupDateList && $index > 4" wz-next="performAction('SAVE_PICKUP_DATE', value)"
                                ng-class="{
                                            'today-div': value.name == 'Today',
                                            'tomorrow-div': value.name == 'Tomorrow',
                                        }">
                                <div class="col-sm-12">
                                    <div class="mybutton">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h5>{{value.name}}</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">{{value.shortDate}} </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <span class="iconsstyle" ng-if="value.price">
                                                    <span class="my_close_button"> $ {{value.price}}</span>
                                                </span>
                                            </div>
                                            <div class="col-sm-2">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" ng-if="!showAllpickupDateList">
                                <div ng-click="loadMorePickupDates()" class="col-sm-12">
                                    <div class="mybutton">
                                        <div class="row">
                                            <div class="col-sm-6">
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
                                                <span class="iconsstyle" ng-if="value.price">
                                                    <span class="my_close_button">$ {{value.price}}</span>
                                                </span>
                                            </div>
                                            <div class="col-sm-2">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="2" wz-heading-title="{{Steps.pickup_time}}" canenter="validateStep">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h2>{{'request_pickup_time' | translate}}</h2>
                                </div>
                                <div class="col-sm-4">
                                    <div class='text-right'>
                                        <div class="div_close_icon" wz-cancel="onCancelOrder()">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="div_slots">
                                <div class="row" ng-repeat="value in TimeSlots" ng-class="{'active': localData.pickupTime && localData.pickupTime.id == value.id }">
                                    <div class="col-sm-12">
                                        <div class="mybutton" ng-click="!localData.pickupTime.leaveAtdoor && performAction('SELECT_PICKUP_TIME', value)" ng-class="{'fade': localData.pickupTime.leaveAtdoor}">
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
                                                    <span class="iconsstyle">
                                                        <span class="my_close_button">$ {{value.price}}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center text-upper">{{'text.or' | translate}}</div>
                            </div>

                            <div class='mybutton'>
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="item ">
                                            <label class="container" for="pickAtDoor"> {{'request_leave_at_door' | translate}}
                                                <input type="checkbox" id='pickAtDoor' class="checky" name="pickAtDoor" ng-model="pickAtDoor" ng-checked="localData.pickupTime && localData.pickupTime.leaveAtdoor" ng-change="performAction('SELECT_PICKUP_AT_DOOR', pickAtDoor)">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <span> {{'text.free' | translate}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class=" wizard-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    <button class="wizard-btn pull-right" wz-next="performAction('SAVE_PICKUP_TIME')">{{'text.next' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="3" wz-heading-title="{{Steps.drop_date}}" canenter="validateStep">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h2> {{'request_drop_date' | translate}}</h2>
                                </div>
                                <div class="col-sm-4">
                                    <div class='text-right'>
                                        <div class="div_close_icon" wz-cancel="onCancelOrder()">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" ng-repeat="value in deliveryDateList" ng-hide="!showAlldeliveryDateList && $index > 4"
                                wz-next="performAction('SAVE_DELIVERY_DATE', value)" ng-class="{
                                                    'tomorrow-div': value.name == 'Tomorrow',
                                                    'day-after-div': value.name == 'day after',
                                                }">
                                <div class="col-sm-12">
                                    <div class="mybutton">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h5>{{value.name}}</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">{{value.shortDate}} </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <span class="iconsstyle" ng-if="value.price">
                                                    <span class="my_close_button"> $ {{value.price}}</span>
                                                </span>
                                            </div>
                                            <div class="col-sm-2">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" ng-if="!showAlldeliveryDateList">
                                <div class="col-sm-12" ng-click="loadMoreDeliveryDates()">
                                    <div class="mybutton">
                                        <div class="row">
                                            <div class="col-sm-6">
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
                                                <span class="iconsstyle" ng-if="value.price">
                                                    <span class="my_close_button">$ {{value.price}}</span>
                                                </span>
                                            </div>
                                            <div class="col-sm-2">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="wizard-btn" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="4" wz-heading-title="{{Steps.drop_time}}" canenter="validateStep">
                            <div class="row">
                                <div class="col-sm-8-col">
                                    <div class='left-align'>
                                        <h4>{{'request_drop_time' | translate}}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-4-col">
                                    <div class='text-right'>
                                        <div class="div_close_icon text-right" wz-cancel="onCancelOrder()">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="div_slots">
                                <div class="row" ng-repeat="value in TimeSlots" ng-class="{'active': localData.deliveryTime && localData.deliveryTime.id == value.id }">
                                    <div class="col-sm-12">
                                        <div class="mybutton" ng-click="!localData.deliveryTime.leaveAtdoor && performAction('SELECT_DELIVERY_TIME', value)" ng-class="{'fade': localData.deliveryTime.leaveAtdoor}">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row">
                                                        <div class="col-sm-12"><img width="70" ng-src="<?php echo get_template_directory_uri(); ?>/images/{{value.time_from}}.png"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h6 class="text-upper"> {{'text.between' | translate}} </h6>
                                                            <h5 class="text-upper"> {{value.time_from}}:00 {{'text.to' | translate}} {{value.time_to}}:00 </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="iconsstyle">
                                                        <span class="my_close_button">$ {{value.price}}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-cente text-upper">{{'text.or' | translate}}</div>
                            </div>

                            <div class="mybutton">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="item ">
                                            <label class="container" for="deliveryDropAtDoor">{{'request_leave_at_door' | translate}}
                                                <input type="checkbox" id="deliveryDropAtDoor" class="checky" name="deliveryAtDoor" ng-model="deliveryDropAtDoor"  ng-checked="localData.deliveryTime && localData.deliveryTime.leaveAtdoor" ng-change="performAction('SELECT_DELIVERY_AT_DOOR', deliveryDropAtDoor)" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <span class="iconsstyle">
                                            <span class="">{{'text.free' | translate}}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="wizard-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    <button class="wizard-btn pull-right" wz-next="performAction('SAVE_DELIVERY_TIME')">{{'text.next' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>

                        <wz-step wz-title="5" wz-heading-title="{{Steps.user_detail}}" wz-disabled="{{isUserLoggedIn}}" canenter="validateStep">
                            <div class="row">
                                <div class="col-sm-8-col">
                                    <div class='left-align'>
                                        <h4>{{'request_pickup_enter_basic_details' | translate}}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-4-col">
                                    <div class='text-right'>
                                        <div class="div_close_icon text-right" wz-cancel="onCancelOrder()">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="alert alert-danger" ng-show="userErr">{{userErrorMessage}}</p>

                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="{{'basic_details.name' | translate}}" ng-model="localData.userDetails.full_name" ng-disabled="loading" />
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
                            <div class="row">
                                <div class="col-sm-8-col">
                                    <div class='left-align'>
                                        <h4>{{'request_pickup_enter_address_details' | translate}}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-4-col">
                                    <div class='text-right'>
                                        <div class="div_close_icon text-right" wz-cancel="onCancelOrder()">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="alert alert-danger" ng-show="addressErr">{{addressErrorMessage}}</p>
                                            
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
                                            <option>{{'text.select' | translate}} {{'address_details.city' | translate}}</option>
                                            <option ng-repeat="value in cityData" value="{{value.id}}">
                                                {{value.title}}
                                            </option>                                 
                                        </select>
                                    </div>
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
                            <div class="row">
                                <div class="col-sm-8-col">
                                    <div class='left-align'>
                                        <h4>{{'request_pickup_enter_payemnt_details' | translate}}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-4-col">
                                    <div class='text-right'>
                                        <div class="div_close_icon text-right" wz-cancel="onCancelOrder()">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8-col">
                                    <iframe id="paymentIframe" width="100%" height="350px"></iframe>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="wizard-btn pull-left" wz-previous="noValidation()">{{'text.previous' | translate}}</button>
                                    <button class="wizard-btn pull-right" wz-next="performAction('GET_PAYMENT_DETAILS')">{{'text.next' | translate}}</button>
                                </div>
                            </div>
                        </wz-step>
                                                    
                        <wz-step wz-title="{{lastStepNumber}}" wz-heading-title="{{Steps.order_summary}}" canenter="validateStep">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class='left-align'>
                                        <h4>{{'request_pickup_order_summary' | translate}}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class='text-right'>
                                        <div class="div_close_icon text-right" wz-cancel="onCancelOrder()">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="alert alert-danger col-sm-12" ng-show="err">{{errorMessage}}</p>
                            <div class="summary-tabs">
                                    <div class="row">
                                    <div class="col-sm-6 text-center">
                                        <div class="row">
                                            <div class="col-sm-12 text-center" style="background-color:#E1F5FE;;padding: 10px;">
                                                <h4>{{'text.pickup' | translate}}</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                {{localData.pickupDate.name}} {{localData.pickupDate.shortDate}}
                                                <br>
                                                <span class="para2heading" ng-if="localData.pickupTime.leaveAtdoor != 'y'">
                                                    {{localData.pickupTime.time_from}}:00 {{'text.to' | translate}}
                                                    {{localData.pickupTime.time_to}}:00 </span>
                                                <span ng-if="localData.pickupTime.leaveAtdoor == 'y'"> {{'request_leave_at_door_short' | translate}} </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-center">
                                        <div class="row">
                                            <div class="col-sm-12  text-center" style="background-color:#E1F5FE;;padding: 10px;    border-top-right-radius: 8px;">
                                                <h4 style='text-transform: uppercase'>{{'text.delivery' | translate}}</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12  text-center">
                                                {{localData.deliveryDate.name}} {{localData.deliveryDate.shortDate}} <br>
                                                <span class="para2heading" ng-if="localData.pickupTime.leaveAtdoor != 'y'">
                                                    {{localData.pickupTime.time_from}}:00 {{'text.to' | translate}}
                                                    {{localData.pickupTime.time_to}}:00 </span>
                                                <span ng-if="localData.pickupTime.leaveAtdoor == 'y'"> {{'request_leave_at_door_short' | translate}} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mybutton">
                                <div class="row">
                                    <div class="col-sm-4"><img src="<?php echo get_template_directory_uri(); ?>/images/dollar.png" width="100%"></div>
                                    <div class="col-sm-8">
                                        <div class="item item-body orderlistbody">
                                            <strong>{{'request_pickup_extra_charges' | translate}}</strong><br>
                                            <div ng-show="localData.pickupDate.price">
                                                <i class="glyphicon glyphicon-plus"> </i> ${{localData.pickupDate.price}} -
                                                {{localData.pickupDate.name}} Pickup
                                            </div>


                                            <div ng-show="localData.pickupTime.price && localData.pickupTime.price != '0'">
                                                <i class="glyphicon glyphicon-plus"> </i> ${{localData.pickupTime.price}} - {{'request_pickup_fixed_time_pickup' | translate}}
                                            </div>

                                        </div>

                                        <div class="item item-body orderlistbody">

                                            <div ng-show="localData.deliveryDate.price != ''">
                                                <i class="glyphicon glyphicon-plus"> </i> ${{localData.deliveryDate.price}} - {{'request_pickup_next_day_delivery' | translate}}
                                            </div>


                                            <div ng-show="localData.deliveryTime.price && localData.deliveryTime.price != '0'">
                                                <i class="glyphicon glyphicon-plus"> </i> ${{localData.deliveryTime.price}} - {{'request_pickup_fixed_time_drop' | translate}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mybutton">
                                <div class="row">
                                    <div class="col-sm-4"><img src="<?php echo get_template_directory_uri(); ?>/images/mastercard.png" width="100%"></div>
                                    <div class="col-sm-6">
                                        <span ng-if="getPayment.payment_type">
                                            <span class="borderdotdot"> {{getPayment.payment_type}}<br> </span>
                                        </span>
                                        <span  ng-if="getPayment.number">
                                            {{'request_pikcup_card_end_with' | translate}}: -<span class="borderdotdot"> {{getPayment.number | limitTo:-4}} </span>
                                        </span>
                                        <span  ng-if="getPayment.expiry_date">
                                            {{'request_pickup_card_expiry_date' | translate}} : - <span class="borderdotdot"> {{getPayment.expiry_date}} </span>
                                        </span>
                                        <span  ng-if="getPayment.expiry_month">
                                            {{'request_pickup_card_expiry_month' | translate}} : - <span class="borderdotdot"> {{getPayment.expiry_month}} </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mybutton">
                                <div class="row">
                                    <div class="col-sm-4"><img src="<?php echo get_template_directory_uri(); ?>/images/address.png" width="100%"></div>
                                    <div class="col-sm-6">
                                        <span ng-if="getAddress != null">
                                            <span class="borderdotdot">{{getAddress.street_name}},
                                            {{'address_details.floor' | translate}} :{{getAddress.floor}}, 
                                            {{'address_details.unit_number' | translate}} : {{getAddress.unit_number}} </span>
                                        </span>
                                    </div>
                                </div>
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