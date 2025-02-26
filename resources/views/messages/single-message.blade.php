@if($message->sender_id === auth()->id())
    <div class="flex justify-end mb-4">
        <div class="bg-[#157e74] text-white rounded-lg py-2 px-4 max-w-[70%]">
            <p class="text-sm">{{ $message->content }}</p>
            <span class="text-xs text-gray-200 mt-1 block">{{ $message->created_at->format('H:i') }}</span>
        </div>
    </div>
@else
    <div class="flex justify-start mb-4">
        <div class="bg-gray-200 rounded-lg py-2 px-4 max-w-[70%]">
            <p class="text-sm">{{ $message->content }}</p>
            <span class="text-xs text-gray-500 mt-1 block">{{ $message->created_at->format('H:i') }}</span>
        </div>
    </div>
@endif 