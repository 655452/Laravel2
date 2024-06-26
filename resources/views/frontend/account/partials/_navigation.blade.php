<div id="titlebar" class="gradient">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="user-profile-titlebar">
                    <div class="user-profile-avatar"><img src="{{ auth()->user()->image }}"  alt=""></div>
                    <div class="user-profile-name">
                        <h2>{{auth()->user()->name}}</h2>
                        <h4>{{auth()->user()->email}}</h4>
                        <h4>{{auth()->user()->phone}}</h4>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

