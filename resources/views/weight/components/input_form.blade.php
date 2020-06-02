<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Login') }}</div>

          <div class="card-body">
              <form method="POST" action="{{ route('weight.store') }}">
                  @csrf

                  <!--日付--->
                  @component('weight.components.input_date_form',['years' => $years, 'months' => $months, 'days' => $days])   @endcomponent

                  
              </form>
          </div>
        </div>
    </div>
  </div>
</div>
