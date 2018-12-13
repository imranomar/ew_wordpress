<?php
/* 
Template Name: Dashboard 
*/


get_header(); 
//echo get_theme_file_uri('common/authenticate.php');die;
if(!is_user_login())	{
	$site_url = get_site_url();
    header('Location: '.$site_url);
}

//include_once();
while(have_posts()) : the_post(); ?>
<div class="container my-4" ng-controller="DashboardCtrl">
    <div class="row">
        <div class="col-12 col-sm-3 mb-3">

            <div class="nav flex-column nav-pills" id="dashboard-tabs" role="tablist" aria-orientation="vertical">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action active" data-toggle="pill" href="javascript:void(0)" data-target="#basic_details" role="tab" aria-controls="dashboard_basic_details" aria-selected="true">{{'basic_details_text' | translate }}</a>
                    <a class="list-group-item list-group-item-action" data-toggle="pill" href="javascript:void(0)" data-target="#address_details" role="tab" aria-controls="dashboard_address_details" aria-selected="false">{{'address_details_text' | translate }}</a>
                    <a class="list-group-item list-group-item-action" data-toggle="pill" href="javascript:void(0)" data-target="#payment_details" role="tab" aria-controls="dashboard_payment_details" aria-selected="false">{{'vaults_details_text' | translate }}</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-9">
            <div ng-if="messageObj" ng-class="messageObj.class">{{messageObj.message}}</div>

            <div class="card">
                <div class="card-body">
                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="basic_details" role="tabpanel" aria-labelledby="dashboard_basic_details">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>{{'basic_details_text' | translate}}</h4>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form name="basicDetailsForm" autocomplete="off" ng-submit="!loading && saveUserDetails(basicDetailsForm)" ng-validate="basicDetailsValidationOptions">
                                            <div class="form-group row">
                                                <label for="fullname" class="col-4 col-form-label">{{'basic_details.name' | translate}} <span class="required">*</span></label>
                                                <div class="col-8">
                                                    <input id="fullname" type="text" name="fullname" class="form-control" ng-model="userdata.full_name" ng-disabled="loading" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-4 col-form-label">{{'basic_details.email' | translate}} <span class="required">*</span></label>
                                                <div class="col-8">
                                                    <input id="email" type="text" name="email" class="form-control" ng-model="userdata.email" ng-disabled="loading" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="phone" class="col-4 col-form-label">{{'basic_details.phone' | translate}} <span class="required">*</span></label>
                                                <div class="col-8">
                                                    <input id="phone" type="text" name="phone" class="form-control" ng-model="userdata.phone" ng-disabled="loading" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="offset-4 col-8">
                                                    <button name="submit" type="submit" class="btn btn-primary">{{'update_details_text' | translate}}</button>
                                                    <button data-toggle="modal" type="button" data-target="#changePassword" class="btn btn-primary">{{'change_password' | translate}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="address_details" role="tabpanel" aria-labelledby="dashboard_address_details">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>
                                        {{'address_details_text' | translate }}
                                        <button type="button" class="btn btn-primary pull-right" ng-click="openAddressModal(null, -1)">{{'text.add' | translate}}</button>
                                    </h4>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-3 p-4" ng-repeat="address in addresses">
                                        <div class="form-group row">
                                            <label for="streetname" class="col-4 col-form-label">{{'address_details.street_name' | translate}} <span class="required">*</span></label>
                                            <div class="col-8">
                                                <label> <span>{{address.street_name}} </span> <span ng-if="address.as_default == 1" class="text-success"><i class="fa fa-check"></i></span></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="floor" class="col-4 col-form-label">{{'address_details.floor' | translate}} <span class="required">*</span></label>
                                            <div class="col-8">
                                                <label> <span>{{address.floor}}</span></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="unitnumber" class="col-4 col-form-label">{{'address_details.unit_number' | translate}} <span class="required">*</span></label>
                                            <div class="col-8">
                                                <label> <span>{{address.unit_number}}</span></label>
                                            </div>
                                        </div>

                                        <!-- <div class="form-group row">
                                            <label for="pincode" class="col-4 col-form-label">{{'address_details.pobox' | translate}} <span class="required">*</span></label>
                                            <div class="col-8">
                                                <label> <span>{{address.pobox}}</span></label>
                                            </div>
                                        </div> -->

                                        <div class="form-group row">
                                            <label for="city" class="col-4 col-form-label">{{'address_details.city' | translate}} <span class="required">*</span></label>
                                            <div class="col-8">
                                                <label> <span ng-bind="displayCityName(address.city_id)"></span></label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-4 col-8">
                                                <button type="button" class="btn btn-primary" ng-click="openAddressModal(address, $index)">{{'text.edit' | translate}}</button>
                                                <button type="button" class="btn btn-danger" ng-click="deleteAddress(address, $index)">{{'text.delete' | translate}}</button>
                                                <button type="button" class="btn btn-primary" ng-click="setDefaultAddress(address, $index)" ng-if="address.as_default != 1">{{'set_default_text' | translate}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment_details" role="tabpanel" aria-labelledby="dashboard_payment_details">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>
                                        {{'vaults_details_text' | translate}}
                                        <button type="button" class="btn btn-primary pull-right" ng-click="openVaultModal()">{{'text.add' | translate}}</button>                                        
                                    </h4>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-3 p-4" ng-repeat="vault in vaults">

                                        <div class="form-group row">
                                            <label for="cardtype" class="col-4 col-form-label">{{'vault_details.card_type' | translate}} <span class="required">*</span></label>
                                            <div class="col-8">
                                                <label> <span ng-bind="displayCardName(vault.payment_type)"></span> <span ng-if="vault.as_default == 1" class="text-success"><i class="fa fa-check"></i></span></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cardnumber" class="col-4 col-form-label">{{'vault_details.card_number' | translate}}<span class="required">*</span></label>
                                            <div class="col-8">
                                                <label> <span>{{vault.number}}</span></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="expirydate" class="col-4 col-form-label">{{'vault_details.expiry_date' | translate}} <span class="required">*</span></label>
                                            <div class="col-8">
                                                <label> <span>{{vault.expiry_date}}</span></label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="expirymonth" class="col-4 col-form-label">{{'vault_details.expiry_month' | translate}} <span class="required">*</span></label>
                                            <div class="col-8">
                                                <label> <span>{{vault.expiry_month}}</span></label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-4 col-8">
                                                <button type="button" class="btn btn-danger" ng-click="deleteVault(vault, $index)">{{'text.delete' | translate }}</button>
                                                <button type="button" class="btn btn-primary" ng-click="setDefaultVault(vault, $index)" ng-if="vault.as_default != 1">{{'set_default_text' | translate }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="changePassword" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <form name="changePasswordForm" ng-submit="!loading && changePassowrd(changePasswordForm)" autocomplete="off" ng-validate="resetPasswordValidationOptions">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{'change_password' | translate}}</h4>
                            <button type="button" class="close mt-1" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div ng-if="popupMessageObj" ng-class="popupMessageObj.class">{{popupMessageObj.message}}</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="oldpassword" class="form-control" placeholder="{{'old_password' | translate}}" ng-model="changePassword.old_password" ng-disabled="loading" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="password" id="newpassword" name="newpassword" class="form-control" ng-model="changePassword.new_password" placeholder="{{'new_password' | translate}}" ng-disabled="loading" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="password" name="confirmpassword" class="form-control" placeholder="{{'confirm_password' | translate}}"  ng-model="changePassword.cpassword" ng-disabled="loading" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" ng-disabled="loading">{{'text.change' | translate}}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" ng-disabled="loading">{{'text.cancel' | translate}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="addressModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <form name="addressForm" ng-submit="!loading && saveAddressDetails(addressForm)" autocomplete="off" ng-validate="addressDetailsValidationOptions">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{address_details && address_details.id > 0?('update_address' | translate):('add_address' | translate)}}</h4>
                            <button type="button" class="close mt-1" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div ng-if="popupMessageObj" ng-class="popupMessageObj.class">{{popupMessageObj.message}}</div>
                            
                            <div class="form-group">
                                <input type="text" name="street_name" class="form-control" placeholder="{{'address_details.street_name' | translate}}" ng-model="addressDetails.street_name" />
                            </div>
                            
                            <div class="form-group">
                                <input type="text" name="floor" class="form-control" placeholder="{{'address_details.floor' | translate}}" ng-model="addressDetails.floor" />
                            </div>

                            <!-- <div class="form-group">
                                <input type="text" name="pobox" class="form-control" placeholder="{{'address_details.po_box' | translate}}"" ng-model="addressDetails.pobox" />
                            </div> -->
                            
                            <div class="form-group">
                                <input type="text" name="unit_number" class="form-control" placeholder="{{'address_details.unit_number' | translate}}"" ng-model="addressDetails.unit_number" />
                            </div>

                            <div class="form-group">
                                <select ng-model="addressDetails.city_id" name="city" class="form-control">
                                    <option value="">{{'text.select' | translate}} {{'address_details.city' | translate}}</option>
                                    <option ng-repeat="value in cityData" value="{{value.id}}">
                                        {{value.title}}
                                    </option>                                 
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" ng-disabled="loading">{{address_details && address_details.id > 0?('text.update' | translate):('text.save' | translate)}}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" ng-disabled="loading">{{'text.cancel' | translate}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="vaultModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{'add_vault' | translate}}</h4>
                        <button type="button" class="close mt-1" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-0">
                        <div ng-if="popupMessageObj" ng-class="popupMessageObj.class">{{popupMessageObj.message}}</div>
                        
                        <div class="paymentIframeContainer"></div>
                        <button type="button" id="loadVaults" ng-click="loadVaults()" style="width:0;height:0;visibility:hidden;"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php endwhile; get_footer(); ?>
