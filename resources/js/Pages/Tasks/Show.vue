<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import Card from 'primevue/card';
import Editor from 'primevue/editor';
import Divider from 'primevue/divider';
import JetButton from '@/Jetstream/Button.vue';


const props = defineProps({
	team: Object,
	task: Object,
    updates: Object
});

const form = useForm({
    message: null
});

function submit() {
	form.post(route('updates.store', props.task), {
		'task': props.task
	});
}
</script>

<template>
    <AppLayout title="">
        <div class="flex justify-center">
            <!-- Updates -->
            <div class="w-1/2">
                <div class="mb-4"><span class="text-2xl">{{ task.title }}</span></div>
                <div v-for="update in props.updates" class="mb-12">
                    <Card>
                        <template #content>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <img :src="update.user.profile_photo_url" :alt="update.user.name" class="rounded-full h-12 w-12 object-cover">
                                    <span class="text-lg font-bold ml-3">{{ update.user.name }}</span>
                                </div>
                                <span class="text-slate-800">{{ update.created_at }}</span>
                            </div>
                            <Divider />
                            <span v-html="update.message"></span>
                        </template>
                    </Card>
                </div>
                
                <form @submit.prevent="submit">
                    <div class="mb-12"><Editor id="message" class="w-full" v-model="form.message" editorStyle="height: 400px" /></div>
                    <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Send
                    </JetButton>
                </form>
            </div> 
            <div>

            </div>
        </div>
    </AppLayout>
</template>