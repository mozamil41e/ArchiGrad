@props(['active' => false])




<a {{ $attributes }} class="flex items-center gap-3 px-4 py-3 rounded-xl  hover:bg-white/20 transition {{ $active ? 'bg-white/15' : '' }}">
    <!-- Home -->
    {{$slot}}
    
</a>