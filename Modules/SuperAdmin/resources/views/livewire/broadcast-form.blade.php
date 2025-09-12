<div>
    <form wire:submit.prevent="send" class="space-y-2">
        <textarea wire:model="message" class="w-full" placeholder="Message"></textarea>
        <button type="submit" class="px-2 py-1 bg-blue-500 text-white">Send</button>
    </form>
</div>
