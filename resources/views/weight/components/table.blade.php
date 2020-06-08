<h3>{{$weight_info['h3_value']}}</h3>
<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
        @foreach ($weight_info['tr_values'] as $header)
          <th scope="col">{{$header}}</th>
        @endforeach
    </tr>
  </thead>
  <tbody>
  @foreach ($weight_info['td_values'] as $column_values)
    <tr>
    
    <!--measured_dt--->
      <td>
        {{$column_values['col0']['value']}}
      </td>

    <!---weight-->
      <td>
        {{$column_values['col1']['value']}}<span class="">{{$column_values['col1']['unit']}}</span>
      </td>

    <!--action-->
      <td>
        <div class="container">
          <div class="row">
            <a class="{{$column_values['col2']['edit']['class']}}" href="{{ action($column_values['col2']['edit']['action'], $column_values['col2']['edit']['param'])}}">{{$column_values['col2']['edit']['value']}}</a>
          
            <form id="delete" method="POST" action="{{ action($column_values['col2']['delete']['action'], $column_values['col2']['edit']['param'])}}">
              @csrf
              @method('DELETE')
              <input type="{{ $column_values['col2']['delete']['type']}}" class="{{$column_values['col2']['delete']['class']}}" value="{{$column_values['col2']['delete']['value']}}" value="{{$column_values['col2']['delete']['value']}}">
            </form>
          </div>
        </div>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>