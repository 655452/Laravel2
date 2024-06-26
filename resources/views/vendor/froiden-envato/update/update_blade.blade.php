<style>
    .note {
        margin-bottom: 15px;
        padding: 15px;
        background-color: #e7f3fe;
        border-left: 6px solid #2196F3;
    }

    ul,
    li {
        list-style: inherit;
        line-height: 20px;
    }

    .note ul {
        margin-bottom: 20px;
        margin-top: 2px;
        margin-left: 10px;
    }

    .version-update-heading {
        color: #39bee6;
    }

    .update-summary-title {
        border-bottom: 1px solid black;
        padding-bottom: 8px
    }

</style>

<div class="row">
    <div class="col-sm-12">
        @php($updateVersionInfo = \App\Http\Functions\EnvatoUpdate::updateVersionInfo())
        @if(isset($updateVersionInfo['lastVersion']))
        <div class="alert alert-danger col-md-12">
            <ol class="mb-0">
                <li>Do Not click Update now button if the application is customized.Youre changes will be lost.</li>
                <li>Take Backup of Files and database before updating.Author will not be responsible if something goes wrong</li>
            </ol>

        </div>

        <div id="update-area" class="m-t-20 m-b-20 col-md-12 white-box d-none">
            Loading...
        </div>


        <div class="note" role="alert">
            <div class="row p-20" style="line-height: 22px">
                <div class="col-md-8">
                    <h6 class="f-24">
                        <i class="fa fa-gift f-20"></i> New Update <span
                            class="badge badge-success">{{ $updateVersionInfo['lastVersion'] }}</span>
                    </h6>
                    <div class="mt-3"><span class="font-weight-bold text-red">Note:</span> You will get
                        logged
                        out after update. Login again to use the application.</div>
                    <div class="font-12 mt-3">
                        If the Update Now button does not work then follow the manual update instructions as mentioned in the documentation.

                    </div>
                </div>
                <div class="col-md-4 text-right mt-3">
                    <a id="update-app" href="javascript:;" class="btn btn-success btn-small">Update Now
                        <i class="fa fa-download"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-12 mt-5">
                <h6 class="update-summary-title"><i class="fa fa-history f-20"></i> Update Summary</h6>
                <div>{!! $updateVersionInfo['updateInfo'] !!}</div>
            </div>
        </div>


        @else
        <div class="alert alert-success col-md-12">
            <div class="col-md-12">You have latest version of this app.</div>
        </div>
        @endif
    </div>
</div>
