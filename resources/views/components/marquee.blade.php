<div class="overflow-hidden bg-gradient-to-r from-violet-400 to-purple-300 py-2">
    <div id="marquee" class="whitespace-nowrap">
        @foreach ($marquees as $marquee)
            @if ($marquee->active)
                <span class="font-bold text-white">{{ $marquee->content }} 🌟 </span>
            @endif  

        @endforeach
        <span class="font-bold text-white"|>আগামী ২৫/০৩/২০২৫ ইং তারিখে বার্ষিক সাধারণ সভা-২০২৪ ও ইফতার মাহফিল এসোসিয়েশন ভবনে অনুষ্ঠিত হবে। 🌟 </span>
        <span class="font-bold text-white">Ramadan Mubarak 🌟 </span>
    </div>
</div>
