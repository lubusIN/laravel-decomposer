@include('Decomposer::components.report_component')
<div class="flex flex-col lg:flex-row gap-6 mt-6">

    <!-- Package & Dependency column -->
    @include('Decomposer::components.packages_datatable')
    <!-- / Package & Dependency column -->

    <!-- Server Environment column -->
    <div class="w-full lg:w-1/3 space-y-6">

        <!-- Laravel Environment -->
        @include('Decomposer::components.laravel_env')

        <!-- Server Environment -->
        @include('Decomposer::components.server_env')

        @if(!empty($extraStats))
        <!-- Extra Stats -->
        @include('Decomposer::components.extra_stats')
        @endif
    </div> <!-- / Server Environment column -->

</div>