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
    updates: Object,
    author: Object
});

const form = useForm({
    message: null
});

function submit() {
	form.post(route('updates.store', props.task), {
		'task': props.task
	});

    // empty message field after submitting.
    //form.message = '';
}

</script>

<template>
    <AppLayout title="">
        <div class="flex flex-col items-center">
            <div class="flex justify-start w-5/6 mb-4"><span class="text-2xl">{{ task.title }}</span></div>
            <div class="flex w-5/6 justify-center">
                <!-- Updates -->
                <div class="w-4/6 mr-20">
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

                <!-- Task Details -->
                <div class="w-2/6">
                    <Card>
                        <template #content>
                            <div class="flex">
                                <span class="w-3/5">Author</span>
                                <span>{{ task.author.name }}</span>
                            </div>
                            <Divider />
                            <div class="flex">
                                <span class="w-3/5">Due by</span>
                                <span>{{ task.due_date }}</span>
                            </div>
                            <Divider />
                            <div class="flex">
                                <span class="w-3/5">Last update</span>
                                <span></span>
                            </div>
                            <Divider />
                            <div class="flex">
                                <span class="w-3/5">Status</span>
                                <span>{{ task.status }}</span>
                            </div>
                            <Divider />
                            <div class="flex">
                                <span class="w-3/5">Assigned to</span>
                                <span>{{ task.assignee.name }}</span>
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
.p-card-content {
    padding: 0 !important;
}
</style>