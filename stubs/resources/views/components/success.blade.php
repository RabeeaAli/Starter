@if (session('status'))
<div class="font-medium text-sm text-white rounded p-3 mt-4 bg-green-600 capitalize">
    {{ session('status') }}
</div>
@endif