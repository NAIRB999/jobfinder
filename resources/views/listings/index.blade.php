<x-layout>
@include('partial._hero')
@include('partial._search')
<div
                class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

@unless (count($listing)== 0)
    
@foreach ($listing as $listing)
    <x-listing-card :listing="$listing"/>
@endforeach

@else
<p>no listings found</p>
@endunless
</div>


</x-layout>