<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import Card from 'primevue/card';
import Editor from 'primevue/editor';
import Divider from 'primevue/divider';


const props = defineProps({
	team: Object,
	task: Object,
    updates: Object
});

const form = useForm({
    message: null
});
</script>

<template>
    <AppLayout title="">
        <div class="flex justify-center">
            <div>
                <div class="mb-4"><span class="text-2xl">{{ task.title }}</span></div>
                <div class="mb-12">
                    <Card v-for="update in props.updates">
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
                    <Editor id="description" class="w-full" v-model="form.message" editorStyle="height: 400px" />
                </form>
            </div> 
            <div>

            </div>
        </div>
    </AppLayout>
</template>