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
  @foreach ($weight_info['td_values'] as $weight)
    <tr>
    
    <!--measured_dt--->
      <td>{{$weight->measured_dt}}</td>

    <!---weight-->
      <td>{{$weight->weight}}<span class="unit">Kg</span></td>

    <!--action-->
      <td>
        <div class="container">
          <div class="row">
            <a class="btn btn-primary" href="{{ action( 'WeightController@edit', $weight->id) }}">編集</a>
          
            <form id="delete" method="POST" action="{{ action( 'WeightController@destroy', $weight->id ) }}">
              @csrf
              @method('DELETE')
              <input type="submit" class="btn btn-danger" value="削除" onClick="delete_alert( event ); return false;">
            </form>
          </div>
        </div>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $weight_info['td_values']->links() }}

<script>
  function delete_alert(e){
    if(!window.confirm('本当に削除しても大丈夫ですか？')){
        window.alert('キャンセルしました');
        return false;
    }
    document.deleteform.submit();
  }
</script>