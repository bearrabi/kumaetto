<div class="form-group">
  <label for="{{$contents_name}}1">{{$label_name}}</label>
</div>
<div class="form-inline">
@if ($contents_values == NULL)
  <input name="{{$contents_name}}1" type="text" class="form-control txtbx" id="{{$contents_name}}1"><span id="dot">.</span>
  <input name="{{$contents_name}}2" type="text" class="form-control txtbx" id="{{$contents_name}}2"><span id="unit">{{$unit}}</span>
@else
  <input name="{{$contents_name}}1" type="text" class="form-control txtbx" id="{{$contents_name}}1" value="{{$contents_values[0]}}"><span id="dot">.</span>
  <input name="{{$contents_name}}2" type="text" class="form-control txtbx" id="{{$contents_name}}2" value="{{$contents_values[1]}}"><span id="unit">{{$unit}}</span>
@endif
</div>