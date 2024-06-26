@php($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo())
@php($envatoUpdateCompanySetting = \Froiden\Envato\Functions\EnvatoUpdate::companySetting())
<div class="table-responsive">

    <table class="table table-bordered">
        <thead>
        <th>System Details</th>
        </thead>
        <tbody>
        <tr>
            <td>Version <span
                        class="pull-right">{{ $updateVersionInfo['appVersion'] }}</span></td>
        </tr>
        <tr>
            <td>Laravel Version <span
                        class="pull-right">{{ $updateVersionInfo['laravelVersion'] }}</span></td>
        </tr>
        <tr>
            <td>PHP Version
                @if (version_compare(PHP_VERSION, '7.1.0') > 0)
                    <span class="pull-right">{{ phpversion() }} <i class="fa fa fa-check-circle text-success"></i></span>
                @else
                    <span class="pull-right">{{ phpversion() }} <i  data-toggle="tooltip" data-original-title="@lang('messages.phpUpdateRequired')" class="fa fa fa-warning text-danger"></i></span>
                @endif
            </td>
        </tr>

        @if(!is_null(env('LICENSE_CODE')))
            <tr>
                <td>License code <span
                            class="pull-right">{{env('LICENSE_CODE')}}</span>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
