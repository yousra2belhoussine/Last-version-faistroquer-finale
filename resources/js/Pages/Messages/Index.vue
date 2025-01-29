<template>
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto px-4 py-6">
            <div v-for="message in messages" :key="message.id" class="mb-4">
                <div :class="[
                    'flex items-start',
                    message.sender_id === $page.props.auth.user.id ? 'justify-end' : 'justify-start'
                ]">
                    <div :class="[
                        'max-w-lg rounded-lg px-4 py-2',
                        message.sender_id === $page.props.auth.user.id 
                            ? 'bg-primary-600 text-white' 
                            : 'bg-gray-100 text-gray-900'
                    ]">
                        <p class="text-sm">{{ message.content }}</p>
                        <span class="text-xs opacity-75">{{ message.created_at }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t px-4 py-4">
            <form @submit.prevent="sendMessage" class="flex gap-2">
                <input 
                    v-model="newMessage" 
                    type="text" 
                    placeholder="Écrivez votre message..." 
                    class="flex-1 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                >
                <button 
                    type="submit" 
                    class="rounded-lg bg-primary-600 px-4 py-2 text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    :disabled="!newMessage.trim()"
                >
                    Envoyer
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import Pusher from 'pusher-js';

const props = defineProps({
    receiverId: {
        type: Number,
        required: true
    },
    initialMessages: {
        type: Array,
        default: () => []
    }
});

const messages = ref(props.initialMessages);
const newMessage = ref('');
let pusher;
let channel;

const connectPusher = () => {
    pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        encrypted: true
    });
    
    channel = pusher.subscribe(`private-user.${$page.props.auth.user.id}`);
    
    channel.bind('new_message', (data) => {
        messages.value.push({
            id: data.id,
            content: data.content,
            sender_id: data.sender.id,
            created_at: data.created_at
        });
        scrollToBottom();
    });
};

const sendMessage = async () => {
    if (!newMessage.value.trim()) return;

    try {
        const response = await axios.post(route('messages.store'), {
            receiver_id: props.receiverId,
            content: newMessage.value
        });

        newMessage.value = '';
        scrollToBottom();
    } catch (error) {
        console.error('Error sending message:', error);
    }
};

const scrollToBottom = () => {
    nextTick(() => {
        const container = document.querySelector('.overflow-y-auto');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });
};

onMounted(() => {
    connectPusher();
    scrollToBottom();
});

onUnmounted(() => {
    if (channel) {
        channel.unsubscribe();
    }
    if (pusher) {
        pusher.disconnect();
    }
});
</script> 