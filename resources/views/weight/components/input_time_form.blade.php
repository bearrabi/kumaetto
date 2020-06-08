<div class="form-group">
  <label for="hour">時刻</label>
</div>

<div class="form-inline">

  <!--時-->
  @if ($input_state == 'readonly')
    <input name="hour" type="text" class="form-control txtbx" id="hour" value="{{$hour}}" readonly>時 &nbsp;&nbsp;
    <input name="minute" type="text" class="form-control txtbx" id="minute" value="{{$minute}}" readonly>分 &nbsp;&nbsp;
    <input name="second" type="text" class="form-control txtbx" id="second"  value="{{$second}}" readonly>秒 
  @elseif ($input_state == 'normal')
    <select name="hour" id="hour" class="form-control selectbx">
      @foreach($hours as $key => $value)
        @if ($value == true)
          <option value="{{$key}}" selected>{{$key}}</option>
        @else
          <option value="{{$key}}">{{$key}}</option>
        @endif
      @endforeach
    </select>時
    
    <!--分-->
    <select name="minute" id="minute" class="form-control selectbx">
      @foreach($minutes as $key => $value)
        @if ($value == true)
          <option value="{{$key}}" selected>{{$key}}</option>
        @else
          <option value="{{$key}}">{{$key}}</option>
        @endif
      @endforeach
    </select>分

    <!--秒-->
    <select name="second" id="second" class="form-control selectbx">
      @foreach($seconds as $key => $value)
        @if ($value == true)
          <option value="{{$key}}" selected>{{$key}}</option>
        @else
          <option value="{{$key}}">{{$key}}</option>
        @endif
      @endforeach
    </select>秒
  @endif    
</div>
