<script setup>
	import AppLayout from '@/Layouts/AppLayout.vue';

	defineProps({
    team: Object,
});

</script>

<template>
	<AppLayout title="Team Tasks">
		<h1>{{ team.name }} Tasks List</h1>
	</AppLayout>
</template>
