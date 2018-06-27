
@extends('admin.layout.master')

@section('body')
<div class="page-content-wrapper">
    <div class="page-content">

        <h3 class="page-title uppercase bold"> {{$data['page_title']}}</h3>
        <hr>
        <div class="portlet light bordered">
            <div class="portlet-body">
                <form class="" action="{{route('admin.UpdateGenSetting')}}" method="post">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-12">
                            <label><strong>* WEBSITE TITLE</strong></label>
                            <input name="websiteTitle" type="text" class="form-control input-lg" value="{{$Gset->website_title}}">
                            @if ($errors->has('websiteTitle'))
                              <span style="color:red;">{{$errors->first('websiteTitle')}}</span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label><strong>* SITE BASE COLOR CODE (without #)</strong></label>
                            <input name="baseColorCode" style="background-color: #{{$Gset->base_color_code}};" type="text" class="form-control" value="{{$Gset->base_color_code}}">
                            @if ($errors->has('baseColorCode'))
                              <span style="color:red;">{{$errors->first('baseColorCode')}}</span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label><strong>* SITE SECONDARY COLOR CODE (without #)</strong></label>
                            <input name="secColorCode" style="background-color: #{{$Gset->sec_color_code}};" type="text" class="form-control" value="{{$Gset->sec_color_code}}">
                            @if ($errors->has('secColorCode'))
                              <span style="color:red;">{{$errors->first('secColorCode')}}</span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label><strong>* Reference Commission (%)</strong></label>
                            <input name="reference_commission" type="text" class="form-control" value="{{$Gset->ref_com}}">
                            @if ($errors->has('reference_commission'))
                              <span style="color:red;">{{$errors->first('reference_commission')}}</span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <br>
                  
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <label><strong>REGISTRATION</strong></label>
                            <input name="registration" type="checkbox" data-toggle="toggle" data-width="100%" data-onstyle="success" data-offstyle="danger" {{$Gset->registration == 1 ? 'checked' : ''}}>
                        </div>
                        <div class="col-lg-4">
                            <label><strong>EMAIL VERIFICATION</strong></label>
                            <input name="emailVerification" type="checkbox" data-toggle="toggle" data-width="100%" data-onstyle="success" data-offstyle="danger" {{$Gset->email_verification == 0 ? 'checked' : ''}}>
                        </div>
                        <div class="col-lg-4">
                            <label><strong>SMS VERIFICATION</strong></label>
                            <input name="smsVerification" type="checkbox" data-toggle="toggle" data-width="100%" data-onstyle="success" data-offstyle="danger" {{$Gset->sms_verification == 0 ? 'checked' : ''}}>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        {{-- <div class="col-lg-4">
                            <label><strong>DECIMAL AFTER POINT</strong></label>
                            <input name="decimalAfterPt" type="text" class="form-control" value="{{$Gset->decimal_after_pt}}">
                            @if ($errors->has('decimalAfterPt'))
                              <span style="color:red;">{{$errors->first('decimalAfterPt')}}</span>
                            @endif
                        </div> --}}
                        <div class="col-lg-4">
                            <label><strong>EMAIL NOTIFICATION</strong></label>
                            <input name="emailNotification" type="checkbox" data-toggle="toggle" data-width="100%" data-onstyle="success" data-offstyle="danger" data-onstyle="success" data-offstyle="danger" {{$Gset->email_notification == 1 ? 'checked' : ''}}>
                        </div>
                        <div class="col-lg-4">
                            <label><strong>SMS NOTIFICATION</strong></label>
                            <input name="smsNotification" type="checkbox" data-toggle="toggle" data-width="100%" data-onstyle="success" data-offstyle="danger" {{$Gset->sms_notification == 1 ? 'checked' : ''}}>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
