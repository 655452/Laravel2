<div class="col-12 col-lg-4 col-xl-3">
    <div class="settings-group">
        <button class="settings-btn" type="button">
            <span>{{ __('show menu') }}</span>
            <i class="fa-solid fa-chevron-down"></i>
        </button>
        @php
            $route = Route::current()->getName();
        @endphp
        <nav class="settings-navs">
            <a href="{{ route('account.profile') }}" class="{{ $route == 'account.profile' ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.1334 9.05866C10.05 9.05033 9.95005 9.05033 9.85838 9.05866C7.87505 8.99199 6.30005 7.36699 6.30005 5.36699C6.30005 3.32533 7.95005 1.66699 10 1.66699C12.0417 1.66699 13.7001 3.32533 13.7001 5.36699C13.6917 7.36699 12.1167 8.99199 10.1334 9.05866Z"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M5.9666 12.133C3.94993 13.483 3.94993 15.683 5.9666 17.0247C8.25827 18.558 12.0166 18.558 14.3083 17.0247C16.3249 15.6747 16.3249 13.4747 14.3083 12.133C12.0249 10.608 8.2666 10.608 5.9666 12.133Z"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>{{ __('frontend.profile') }}</span>
            </a>
            <a href="{{ route('account.password') }}" class="{{ $route == 'account.password' ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M16.4917 12.4416C14.775 14.1499 12.3167 14.6749 10.1584 13.9999L6.23337 17.9166C5.95004 18.2083 5.39171 18.3833 4.99171 18.3249L3.17504 18.0749C2.57504 17.9916 2.01671 17.4249 1.92504 16.8249L1.67504 15.0083C1.61671 14.6083 1.80837 14.0499 2.08337 13.7666L6.00004 9.84994C5.33337 7.68327 5.85004 5.22494 7.56671 3.5166C10.025 1.05827 14.0167 1.05827 16.4834 3.5166C18.95 5.97494 18.95 9.98327 16.4917 12.4416Z"
                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M5.7417 14.5752L7.65837 16.4919" stroke-width="1.5" stroke-miterlimit="10"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M12.0833 9.16699C12.7736 9.16699 13.3333 8.60735 13.3333 7.91699C13.3333 7.22664 12.7736 6.66699 12.0833 6.66699C11.3929 6.66699 10.8333 7.22664 10.8333 7.91699C10.8333 8.60735 11.3929 9.16699 12.0833 9.16699Z"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>{{ __('frontend.change_password') }} </span>
            </a>
            <a href="{{ route('account.order') }}" class="{{ $route == 'account.order' || ($route == 'account.report' && $order->id)  || ($route == 'account.order.show' && $order->id) ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6.25 6.39192V5.58358C6.25 3.70858 7.75833 1.86692 9.63333 1.69192C11.8667 1.47525 13.75 3.23358 13.75 5.42525V6.57525"
                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M7.5001 18.3337H12.5001C15.8501 18.3337 16.4501 16.992 16.6251 15.3587L17.2501 10.3587C17.4751 8.32533 16.8918 6.66699 13.3334 6.66699H6.66677C3.10843 6.66699 2.5251 8.32533 2.7501 10.3587L3.3751 15.3587C3.5501 16.992 4.1501 18.3337 7.5001 18.3337Z"
                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12.9128 9.99967H12.9203" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M7.07884 9.99967H7.08632" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>{{ __('frontend.my_orders') }} </span>
            </a>
            <a href="{{ route('account.reservations') }}"
                class="{{ $route == 'account.reservations' ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.66675 1.66699V4.16699" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M13.3333 1.66699V4.16699" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2.91675 7.5752H17.0834" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M18.3334 15.8333C18.3334 16.4583 18.1584 17.05 17.8501 17.55C17.2751 18.5167 16.2167 19.1667 15.0001 19.1667C14.1584 19.1667 13.3918 18.8583 12.8084 18.3333C12.5501 18.1167 12.3251 17.85 12.1501 17.55C11.8417 17.05 11.6667 16.4583 11.6667 15.8333C11.6667 13.9917 13.1584 12.5 15.0001 12.5C16.0001 12.5 16.8917 12.9417 17.5001 13.6333C18.0167 14.225 18.3334 14.9917 18.3334 15.8333Z"
                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.7002 15.8333L14.5252 16.6583L16.3002 15.0166" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M17.5 7.08366V13.6336C16.8917 12.942 16 12.5003 15 12.5003C13.1583 12.5003 11.6667 13.992 11.6667 15.8337C11.6667 16.4587 11.8417 17.0503 12.15 17.5503C12.325 17.8503 12.55 18.117 12.8083 18.3337H6.66667C3.75 18.3337 2.5 16.667 2.5 14.167V7.08366C2.5 4.58366 3.75 2.91699 6.66667 2.91699H13.3333C16.25 2.91699 17.5 4.58366 17.5 7.08366Z"
                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9.99632 11.4167H10.0038" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M6.91185 11.4167H6.91933" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M6.91185 13.9167H6.91933" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>{{ __('frontend.my_reservations') }}</span>
            </a>
            <a href="{{ route('account.transaction') }}"
                class="{{ $route == 'account.transaction' ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.66675 8.33301H18.3334" stroke-width="1.5" stroke-miterlimit="10"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M9.62365 17.0831H5.36533C2.40699 17.0831 1.65698 16.3498 1.65698 13.4248V6.57481C1.65698 3.92481 2.27367 3.07481 4.59867 2.94147C4.83201 2.93314 5.09033 2.9248 5.36533 2.9248H14.6236C17.582 2.9248 18.332 3.65814 18.332 6.58314V10.2581"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M5 13.333H8.33333" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M18.3334 15.0003C18.3334 15.6253 18.1584 16.217 17.8501 16.717C17.2751 17.6837 16.2167 18.3337 15.0001 18.3337C13.7834 18.3337 12.7251 17.6837 12.1501 16.717C11.8418 16.217 11.6667 15.6253 11.6667 15.0003C11.6667 13.1587 13.1584 11.667 15.0001 11.667C16.8417 11.667 18.3334 13.1587 18.3334 15.0003Z"
                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.7012 14.9993L14.5262 15.8243L16.3012 14.1826" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span> {{ __('frontend.transaction') }}</span>
            </a>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="{{ $route == 'logout' ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.41675 6.3002C7.67508 3.3002 9.21675 2.0752 12.5917 2.0752H12.7001C16.4251 2.0752 17.9167 3.56686 17.9167 7.29186V12.7252C17.9167 16.4502 16.4251 17.9419 12.7001 17.9419H12.5917C9.24175 17.9419 7.70008 16.7335 7.42508 13.7835"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12.4999 10H3.0166" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M4.87492 7.20801L2.08325 9.99967L4.87492 12.7913" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>{{ __('logout') }}</span>
            </a>
            <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
            </form>
        </nav>

    </div>
</div>
