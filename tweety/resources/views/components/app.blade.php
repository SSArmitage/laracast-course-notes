@component('master')
    <!-- 3 column layout section - repeated for timeline and profile -->
        <!-- if the user is not logged in, the '_sidebar-links' & '_friends-list' will casue errors to be thrown... in that case, remove these statments, log in, and the put them back -->
        <!-- need to put some kind of conditional here to check if user is logged in??? -->;
        <section class="px-8">
            <main class="container mx-auto">
                <!-- only for large screen flex & set width -->
                <div class="lg:flex lg:justify-between">
                    <!-- sidebar - links -->
                    @if(auth()->check())
                        <div class="lg:w-32">
                            @include('_sidebar-links')
                        </div>
                    @endif
                    <!-- timeline OR profile content-->
                    <div 
                    class="lg:flex-1 lg:mx-10" 
                    style="max-width:700px">
                        {{ $slot }}
                    </div>
                    <!-- friends list -->
                    @if(auth()->check())
                        <div 
                        class="lg:w-1/6 bg-blue-100 p-4" 
                        style="
                            height:max-content;
                            border-radius:1.25rem"
                        >
                            @include('_friends-list')
                        </div>
                    @endif
                </div>
            </main>
        </section>
@endcomponent