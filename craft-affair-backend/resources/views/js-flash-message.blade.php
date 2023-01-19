@if ($message = Session::get('success'))
<script type="text/javascript">
Lobibox.notify('success', {
    icon:false,
    msg: '{{ $message }}'
});
</script>
@endif

@if ($message = Session::get('error'))
<script type="text/javascript">
Lobibox.notify('error', {
    icon:false,
    msg: '{{ $message }}'
});
</script>
@endif

@if ($message = Session::get('warning'))
<script type="text/javascript">
Lobibox.notify('warning', {
    icon:false,
    msg: '{{ $message }}'
});
</script>
@endif

@if ($message = Session::get('info'))
<script type="text/javascript">
Lobibox.notify('info', {
    icon:false,
    msg: '{{ $message }}'
});
</script>
@endif