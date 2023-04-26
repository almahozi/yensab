<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import Card from 'primevue/card';
import Editor from 'primevue/editor';
import Divider from 'primevue/divider';
import JetButton from '@/Jetstream/Button.vue';
import Checkbox from 'primevue/checkbox';
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import FileUpload from 'primevue/fileupload';

const props = defineProps({
	team: Object,
    members: Object,
	task: Object,
    updates: Object,
    author: Object,
    errors: Object,
    statuses: Object
});

const createUpdateForm = useForm({
    message: null,
    assignee: null,
    reassign: ref(false),
    attachments: null
});

const fileUpload = ref(null);

const editTaskForm = useForm({
    title: props.task.title,
    dueDate: props.task.due_date,
    status: props.task.status,
});

let showEditDialog = ref(false);


function submitCreateUpdateForm() {
	createUpdateForm.post(route('updates.store', props.task), {
		onSuccess: function() {
            createUpdateForm.reset();
            fileUpload.value.clear();
        },
	});
}

function submitEditTaskForm() {
    editTaskForm.patch(route('tasks.update', [props.team, props.task]), {
        onSuccess: () => showEditDialog.value = false,
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    return date.toLocaleString('en-US', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
    hour12: true,
    timeZone: 'UTC'
    });
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
                                        <div class="flex flex-col ml-3">
                                            <span class="text-lg font-bold mt-3">{{ update.user.name }}</span>
                                            <span class="text-gray-500 text-xs">{{ formatDate(update.created_at) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col w-3/12">
                                        <div v-if="update.assignee_id" class="flex items-center">
                                            <!-- <svg height="32px" width="32px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 508 508" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle style="fill:#324A5E;" cx="254" cy="254" r="254"></circle> <g> <path style="fill:#FFFFFF;" d="M444.4,310c-22,21.2-53.6,34.4-88.8,34.4s-67.2-13.2-88.8-34.4l0,0c3.6-11.6,12-21.2,22.8-26.4 l34.4-16.4c1.2-4.4,6-10.4,6.4-10.4c-2.4-3.6-4.4-8-6.4-12.4c-2.8,0-5.6-2.4-7.2-5.6c-1.6-3.2-1.6-7.2,0-9.2 c-5.6-14.4-9.2-36.4,8.8-52.8l-8.8,2c0,0,10.8-20,32.4-12.8c0,0-2-3.2-8.8-5.2c0,0,9.6-4,15.2,2.4c0,0,3.2-2.8,0-5.2 c0,0,16.8,0.4,31.6,14.4c19.6,18.4,14.8,42.4,8,58.4c0.8,2,0.4,5.2-0.8,7.6c-1.6,2.8-4,4.8-6.4,5.6c-1.2,2-5.6,9.6-7.2,12.4 c0.4,0,5.6,6.4,6.4,10.8l34.4,16.4C432.4,288.8,440.4,298.4,444.4,310L444.4,310z"></path> <path style="fill:#FFFFFF;" d="M241.6,310c-22,21.2-53.6,34.4-88.8,34.4S85.6,331.2,64,310l0,0c3.6-11.6,12-21.2,22.8-26.4 l34.4-16.4c1.2-4.4,6-10.4,6.4-10.4c-2.4-3.6-4.4-8-6.4-12.4c-2.8,0-5.6-2.4-7.2-5.6c-1.6-3.2-1.6-7.2,0-9.2 c-5.6-14.4-9.2-36.4,8.8-52.8l-8.8,1.6c0,0,10.8-20,32.4-12.8c0,0-2-3.2-8.8-5.2c0,0,9.6-4,15.2,2.4c0,0,3.2-2.8,0-5.2 c0,0,16.8,0.4,31.6,14.4c19.6,18.4,14.8,42.4,8,58.4c0.8,2,0.4,5.2-0.8,7.6c-1.6,2.8-4,4.8-6.4,5.6c-1.2,2-5.6,9.6-7.2,12.4 c0.4,0,5.6,6.4,6.4,10.8l34.4,16.4C229.6,288.8,238,298.4,241.6,310L241.6,310z"></path> </g> <path style="fill:#84DBFF;" d="M361.6,122.8c-0.4,0.4-0.4,0.8-0.8,0.8c-0.8,0.8-2,1.2-3.2,1.6l-25.6,4.4c-3.2,0.4-6.4-1.6-7.2-4.8 c-0.4-3.2,1.6-6.4,4.8-7.2l11.2-2c-63.2-41.2-146-34.8-202.4,17.6c-4,3.6-7.6,7.6-11.2,11.6c-1.2,1.2-2.8,2-4.4,2l0,0 c-5.2,0-8-6.4-4.4-10.4c4-4.4,8-8.4,12-12.4C161.6,95.2,202,78.4,244,76.8c36.8-1.6,72.8,8.8,103.2,28.4l-1.2-10 c-0.4-3.2,1.6-6.4,4.8-7.2c3.2-0.8,6.4,1.6,7.2,4.8l4.8,25.2C362.8,119.6,362.4,121.6,361.6,122.8z"></path> <path style="fill:#FF7058;" d="M379.2,361.6c5.2,0,8,6.4,4.4,10.4s-7.6,8-11.6,12c-31.2,28.8-71.6,45.6-113.6,47.2 c-37.6,1.6-74.4-9.2-105.6-30l2,10c0.4,2-0.4,4.4-2,5.6c-0.8,0.8-2,1.2-3.2,1.6c-3.2,0.4-6.4-1.6-7.2-4.8l-4.4-24.8 c-0.4-1.6,0-3.2,0.8-4.8c0.8-1.2,2.4-2.4,4-2.4l25.6-4.4c3.2-0.4,6.4,1.6,7.2,4.8c0.4,3.2-1.6,6.4-4.8,7.2l-11.2,2 c63.2,42.8,147.2,36.4,204-16.4c4-3.6,7.6-7.2,10.8-11.2C376,362.4,377.6,361.6,379.2,361.6L379.2,361.6z"></path> </g></svg> -->
                                            <svg height="32px" width="32px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 489.9 489.9" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path style="fill:#3C92CA;" d="M90.3,96.956c-3.8,3.9-3.8,10.2,0.2,14c3.9,3.8,10.2,3.8,14-0.2c35.8-36.7,83.8-57.2,135-57.8 c50-0.6,97.4,18,133.7,52.2l-18.2,0.2c-5.5,0.1-9.8,4.5-9.8,10c0.1,5.4,4.5,9.8,9.9,9.8h0.1l42.2-0.5c5.5-0.1,9.8-4.5,9.8-10 l-0.4-42.1c-0.1-5.4-4.5-9.8-9.9-9.8h-0.1c-5.5,0.1-9.8,4.5-9.8,10l0.2,18.4c-40.1-38-92.6-58.6-147.9-58 C182.7,33.956,129.8,56.556,90.3,96.956z"></path> <path style="fill:#3C92CA;" d="M378.9,379.056c-35.8,36.7-83.8,57.2-135,57.8c-50,0.6-97.4-18-133.7-52.2l18.2-0.2 c5.5-0.1,9.8-4.5,9.8-10c-0.1-5.4-4.5-9.8-9.9-9.8h-0.1l-42.2,0.5c-5.5,0.1-9.8,4.5-9.8,10l0.5,42.2c0.1,5.4,4.5,9.8,9.9,9.8h0.1 c5.5-0.1,9.8-4.5,9.8-10l-0.2-18.4c39.5,37.4,90.9,58,145.4,58c0.8,0,1.7,0,2.5,0c56.5-0.7,109.5-23.3,149-63.7 c3.8-3.9,3.8-10.2-0.2-14C389,375.056,382.8,375.156,378.9,379.056z"></path> <path style="fill:#2C2F33;" d="M78.2,240.256c0-3.3-1.7-6.4-4.4-8.2c-1.8-1.2-2.8-3.2-2.8-5.3v-36.1c0-12.5,10.1-22.6,22.6-22.6 h7.8c12.5,0,22.6,10.1,22.6,22.6v36.1c0,2.1-1.1,4.1-2.8,5.3c-2.8,1.8-4.4,4.9-4.4,8.2v34.8c0,4.4,2.5,8.4,6.5,10.3 c4.5,2.2,27.8,14,49.4,31.7c1.7,1.4,2.7,3.6,2.7,5.9v24.7c0,5.5,4.4,9.9,9.9,9.9s9.9-4.4,9.9-9.9v-24.7c0-8.2-3.6-15.9-10-21.2 c-18.9-15.6-39.2-26.9-48.6-31.8v-25.1c4.6-4.8,7.3-11.3,7.3-18.1v-36.1c0-23.4-19-42.4-42.4-42.4h-7.8c-23.4,0-42.4,19-42.4,42.4 v36.1c0,6.8,2.6,13.3,7.3,18.1v25.1c-9.5,4.9-29.7,16.3-48.6,31.8c-6.3,5.2-10,12.9-10,21.2v24.7c0,5.5,4.4,9.9,9.9,9.9 s9.9-4.4,9.9-9.9v-24.7c0-2.3,1-4.4,2.7-5.9c21.5-17.7,44.9-29.5,49.4-31.7c3.9-1.9,6.5-6,6.5-10.3v-34.8H78.2z"></path> <path style="fill:#2C2F33;" d="M479.9,301.856c-18.9-15.6-39.2-26.9-48.6-31.8v-25.1c4.6-4.8,7.3-11.3,7.3-18.1v-36.1 c0-23.4-19-42.4-42.4-42.4h-7.8c-23.4,0-42.4,19-42.4,42.4v36.1c0,6.8,2.6,13.3,7.3,18.1v25c-9.5,4.9-29.7,16.3-48.6,31.8 c-6.3,5.2-10,12.9-10,21.2v24.7c0,5.5,4.4,9.9,9.9,9.9s9.9-4.4,9.9-9.9v-24.7c0-2.3,1-4.4,2.7-5.9c21.5-17.7,44.9-29.5,49.4-31.7 c3.9-1.9,6.4-6,6.4-10.3v-34.8c0-3.3-1.7-6.4-4.4-8.2c-1.8-1.2-2.8-3.2-2.8-5.3v-36.1c0-12.5,10.1-22.6,22.6-22.6h7.8 c12.5,0,22.6,10.1,22.6,22.6v36.1c0,2.1-1.1,4.1-2.8,5.3c-2.8,1.8-4.4,4.9-4.4,8.2v34.8c0,4.4,2.5,8.4,6.4,10.3 c4.5,2.2,27.9,14,49.4,31.7c1.7,1.4,2.7,3.6,2.7,5.9v24.7c0,5.5,4.4,9.9,9.9,9.9s9.9-4.4,9.9-9.9v-24.7 C489.8,314.756,486.2,307.056,479.9,301.856z"></path> </g> </g> </g></svg>
                                            <span class="pl-2">{{ update.assignee.name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <Divider />
                                <span v-html="update.message"></span>
                            </template>
                            <template #footer>
                                <div v-if="Object.keys(update.attachments).length">
                                    <Divider />
                                    <div v-for="attachment in update.attachments">
                                        <a :href="route('attachments.show', attachment)">{{ attachment.name }}</a>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </div>
                    
                    <!-- New Update Form -->
                    <form @submit.prevent="submitCreateUpdateForm">
                        <div><Editor class="w-full" v-model="createUpdateForm.message" editorStyle="height: 400px" /></div>
                        <div class="text-red-700 mb-12" v-if="errors.message">{{ errors.message }}</div>
                        
                        <div class="mt-10 flex items-center">
                            <Checkbox inputId="reassign" v-model="createUpdateForm.reassign" :binary="true" />
                            <label class="ml-1 mr-1" for="reassign">Reassign Task to: </label>
                            <Dropdown :disabled="!createUpdateForm.reassign" id="assignee" class="w-2/6" v-model="createUpdateForm.assignee" :options="members" optionLabel="name" optionValue="id" placeholder="" :filter="true" />
                        </div>
                        <div class="text-red-700" v-if="errors.assignee">{{ errors.assignee }}</div>

                        <div class="mt-10">
                            <FileUpload ref="fileUpload" accept=".pdf" :maxFileSize="5000000" :multiple="true" :showUploadButton="false" @select="createUpdateForm.attachments = $event.files">
                                <template #empty>
                                    <p>Drag and drop files to here to upload.</p>
                                </template>
                            </FileUpload>
                            <!-- <input type="file" @input="createUpdateForm.attachments = $event.target.files" /> -->
                        </div>
                        <div class="text-red-700" v-if="errors.attachments">{{ errors.attachments }}</div>

                        <JetButton class="mt-10 mb-5" :class="{ 'opacity-25': createUpdateForm.processing }" :disabled="createUpdateForm.processing">Send</JetButton>
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
                    <div class="mt-10">
                        <Button label="EDIT" severity="secondary" @click="showEditDialog = true" />
                    </div>

                    <!-- Edit Task Dialog -->
                    <Dialog v-model:visible="showEditDialog" modal header="Edit Task" :style="{ width: '30vw' }">
                        <form>
                            <div class="flex flex-col">
                                <label class="text-lg pr-10">Title</label>
                                <InputText id="title" class="w-full" type="text" v-model="editTaskForm.title" />
                                <div class="text-red-700" v-if="errors.title">{{ errors.title }}</div>
                            </div>

                            <div class="flex flex-col mt-10">
                                <label class="text-lg pr-10">Status</label>
                                <Dropdown id="status" class="w-full" v-model="editTaskForm.status" :options="statuses" optionLabel="name" optionValue="name" :filter="false" />
                                <div class="text-red-700" v-if="errors.status">{{ errors.title }}</div>
                            </div>

                            <div class="flex flex-col mt-10">
                                <label class="text-lg pr-10">Due Date</label>
                                <Calendar id="dueDate" v-model="editTaskForm.dueDate" dateFormat="d/m/yy" />
                                <div class="text-red-700" v-if="errors.dueDate">{{ errors.dueDate }}</div>
                            </div>
                        </form>
                        <template #footer>
                            <Button label="Cancel" @click="showEditDialog = false" text />
                            <Button label="Update" :class="{ 'opacity-25': editTaskForm.processing }" :disabled="editTaskForm.processing" @click="submitEditTaskForm(showEditDialog)" autofocus />
                        </template>
                    </Dialog>
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