<template>
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto px-4 py-6">
            <div v-for="message in messages" :key="message.id" class="mb-4">
                <div :class="[
                    'flex items-start',
                    message.sender?.id === $page.props.auth.user.id ? 'justify-end' : 'justify-start'
                ]">
                    <div v-if="message.sender && message.sender?.id !== $page.props.auth.user.id" class="flex-shrink-0 mr-3">
                        <img v-if="message.sender.profile_photo_url" 
                             :src="message.sender.profile_photo_url" 
                             :alt="message.sender.name"
                             class="h-8 w-8 rounded-full">
                        <div v-else class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-600">
                                {{ message.sender.name.charAt(0) }}
                            </span>
                        </div>
                    </div>
                    
                    <div :class="[
                        'max-w-lg rounded-lg px-4 py-2',
                        message.sender?.id === $page.props.auth.user.id 
                            ? 'bg-primary-600 text-white' 
                            : 'bg-gray-100 text-gray-900',
                        message.is_system_message ? 'bg-gray-200 text-gray-600 italic text-sm' : ''
                    ]">
                        <p class="text-sm" v-if="message.type === 'text'">{{ message.content }}</p>
                        <div v-else-if="message.type === 'file'" class="flex items-center">
                            <a :href="message.file_url" 
                               target="_blank" 
                               class="flex items-center text-sm hover:underline">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                {{ message.content }}
                            </a>
                        </div>
                        <div class="mt-1 flex items-center space-x-2">
                            <span class="text-xs opacity-75">{{ formatDate(message.created_at) }}</span>
                            <span v-if="message.is_edited" class="text-xs opacity-75">(modifié)</span>
                        </div>
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
                <input
                    type="file"
                    ref="fileInput"
                    @change="handleFileUpload"
                    class="hidden"
                >
                <button 
                    type="button"
                    @click="$refs.fileInput.click()"
                    class="rounded-lg bg-gray-100 px-4 py-2 text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </button>
                <button 
                    type="submit" 
                    class="rounded-lg bg-primary-600 px-4 py-2 text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    :disabled="!canSendMessage"
                >
                    Envoyer
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { formatDistanceToNow } from 'date-fns';
import { fr } from 'date-fns/locale';

const props = defineProps({
    conversationId: {
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
const selectedFile = ref(null);
const fileInput = ref(null);

const canSendMessage = computed(() => {
    return newMessage.value.trim() || selectedFile.value;
});

function formatDate(date) {
    return formatDistanceToNow(new Date(date), { addSuffix: true, locale: fr });
}

function handleFileUpload(event) {
    selectedFile.value = event.target.files[0];
    if (selectedFile.value) {
        newMessage.value = selectedFile.value.name;
    }
}

async function sendMessage() {
    if (!canSendMessage.value) return;

    const formData = new FormData();
    formData.append('conversation_id', props.conversationId);
    
    if (selectedFile.value) {
        formData.append('type', 'file');
        formData.append('file', selectedFile.value);
    } else {
        formData.append('type', 'text');
        formData.append('content', newMessage.value);
    }

    try {
        const response = await axios.post(route('messages.store', props.conversationId), formData);
        messages.value.unshift(response.data.data);
        newMessage.value = '';
        selectedFile.value = null;
        if (fileInput.value) {
            fileInput.value.value = '';
        }
    } catch (error) {
        console.error('Erreur lors de l\'envoi du message:', error);
    }
}

// Écouter les nouveaux messages
let channel;

onMounted(() => {
    channel = window.Echo.private(`conversation.${props.conversationId}`)
        .listen('NewMessageEvent', (e) => {
            if (e.message.sender?.id !== window.$page.props.auth.user.id) {
                messages.value.unshift(e.message);
            }
        });
});

onUnmounted(() => {
    if (channel) {
        channel.stopListening('NewMessageEvent');
    }
});
</script> 