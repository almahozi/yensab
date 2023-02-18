<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import { Link } from '@inertiajs/inertia-vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Card from 'primevue/card';
import Button from 'primevue/button';


const props = defineProps({
	team: Object,
	tasks: Object
});
console.log(props.team);
</script>

<template>
	<AppLayout title="Team Tasks">
		<div class="flex justify-center pt-12">
			<div class="flex flex-col w-4/5 justify-center">
				<div>
					<JetButton><Link :href="route('tasks.create', team)">NEW TASK</Link></JetButton>
				</div>

				<div class="grow pt-6">
					<Card>
						<template #content>
							<DataTable :value="tasks">
								<Column field="title" header="Title"></Column>
								<Column field="assignee.name" header="Assignee"></Column>
								<Column field="status" header="Status"><Badge></Badge></Column>
								<Column field="due_date" header="Due Date"></Column>
							</DataTable>
						</template>
					</Card>
				</div>
			</div>
		</div>
		
	</AppLayout>
</template>
