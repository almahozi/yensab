<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputText from 'primevue/inputtext';
import Card from 'primevue/card';
import Divider from 'primevue/divider';
import Editor from 'primevue/editor';
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';


const props = defineProps({ 
	team : Object,
	members: Array,
	errors: Object
});

const form = useForm({
	title: null,
	assignee: null,
	dueDate: null,
	description: null
});

function submit() {
	form.post(route('tasks.store', props.team), {
		'team': props.team
	});
}
</script>

<template>
	<AppLayout title="Create Task">

		<div class="flex justify-center pt-12">
			<Card class="w-3/5">
				<template #title>
					New Task
					<Divider />
				</template>

				<template #content>
					<form @submit.prevent="submit">
						
						<div class="pb-10">
							<label class="text-lg font-bold pr-10">Title</label>
							<InputText id="title" class="w-full" type="text" v-model="form.title" />
							<div class="text-red-700" v-if="errors.title">{{ errors.title }}</div>
						</div>

						<div class="pb-10">
							<label class="text-lg font-bold pr-10">Assign To</label>
							<Dropdown id="assignee" class="w-full" v-model="form.assignee" :options="members" optionLabel="name" optionValue="id" placeholder="Unassigned" :filter="true" />
							<div class="text-red-700" v-if="errors.assignee">{{ errors.assignee }}</div>
						</div>

						<div class="pb-10">
							<label class="text-lg font-bold pr-10">Due Date</label>
							<Calendar id="dueDate" class="w-full" v-model="form.dueDate" dateFormat="d/m/yy" />
							<div class="text-red-700" v-if="errors.dueDate">{{ errors.dueDate }}</div>
						</div>

						<div class="pb-10">
							<label class="text-lg font-bold pr-10">Description</label>
							<Editor id="description" class="w-full" v-model="form.description" editorStyle="height: 400px" />
							<div class="text-red-700" v-if="errors.description">{{ errors.description }}</div>
						</div>

						<div>
							<Button type="submit" :disabled="form.processing" label="Create" />
						</div>
					</form>
				</template>
			</Card>
		</div>

	</AppLayout>
</template>