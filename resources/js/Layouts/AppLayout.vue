<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import JetBanner from '@/Jetstream/Banner.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetNavLink from '@/Jetstream/NavLink.vue';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';
import VerticalNavItem from '@/Components/VerticalNavItem.vue';

import 'primevue/resources/primevue.min.css';
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primeicons/primeicons.css';


defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <JetBanner />

        <div class="flex">
            <!-- Left Column -->
            <div class="flex-shrink w-60 bg-teal-800">
                <!-- Logo -->
                <div class="bg-teal-900 flex items-center justify-center max-w-xs h-20">
                    <Link :href="route('tasks.index', $page.props.user.current_team)">
                        <JetApplicationMark />
                    </Link>
                </div>
                <!-- Vertical Nav -->
                <div>
                    <VerticalNavItem>
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="white">
                              <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </template>
                        <template #text>
                            <span class="px-3">Teams</span>
                        </template>
                    </VerticalNavItem>
                    <div v-for="team in $page.props.user.all_teams" :key="team.id" class="pl-14 hover:bg-teal-900">
                        <form @submit.prevent="switchToTeam(team)">
                            <button v-if="team.id == $page.props.user.current_team_id" class="text-white text-sm font-bold w-full text-left" type="submit">{{ team.name }}</button>
                            <button v-else class="text-white text-sm w-full text-left" type="submit">{{ team.name }}</button>
                        </form>
                    </div>
                    <div class="text-white text-sm ml-14 mt-6 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pr-1" viewBox="0 0 20 20" fill="white">
                          <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <Link :href="route('teams.create')">Create a team</Link>
                    </div>
                    
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex-grow min-h-screen bg-gray-100">
                <nav class="bg-white border-b border-gray-100">
                    <!-- Primary Navigation Menu -->
                    <div class="px-4">
                        <div class="flex justify-between h-20">
                            <div class="flex w-full">
                                <!-- Current Team Name -->
                                <div class="flex flex-col justify-center w-1/6">
                                    <span class="font-bold text-2xl"># {{ $page.props.user.current_team.name }}</span>
                                </div>
                                <!-- Navigation Links -->
                                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <JetNavLink :href="route('tasks.index', $page.props.user.current_team)" :active="route().current('tasks.index')">
                                        Tasks
                                    </JetNavLink>
                                    <JetNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                        Files
                                    </JetNavLink>
                                    <JetNavLink :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">
                                        Team Settings
                                    </JetNavLink>
                                </div>
                            </div>

                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <JetDropdown align="right" width="48">
                                        <template #trigger>
                                            <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                            </button>

                                            <span v-else class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                    {{ $page.props.user.name }}

                                                    <svg
                                                        class="ml-2 -mr-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Manage Account
                                            </div>

                                            <JetDropdownLink :href="route('profile.show')">
                                                Profile
                                            </JetDropdownLink>

                                            <JetDropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                                API Tokens
                                            </JetDropdownLink>

                                            <div class="border-t border-gray-100" />

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <JetDropdownLink as="button">
                                                    Log Out
                                                </JetDropdownLink>
                                            </form>
                                        </template>
                                    </JetDropdown>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-mr-2 flex items-center sm:hidden">
                                <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                    <svg
                                        class="h-6 w-6"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Navigation Menu -->
                    <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                        <div class="pt-2 pb-3 space-y-1">
                            <JetResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </JetResponsiveNavLink>
                        </div>

                        <!-- Responsive Settings Options -->
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="flex items-center px-4">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                </div>

                                <div>
                                    <div class="font-medium text-base text-gray-800">
                                        {{ $page.props.user.name }}
                                    </div>
                                    <div class="font-medium text-sm text-gray-500">
                                        {{ $page.props.user.email }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <JetResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                    Profile
                                </JetResponsiveNavLink>

                                <JetResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                    API Tokens
                                </JetResponsiveNavLink>

                                <!-- Authentication -->
                                <form method="POST" @submit.prevent="logout">
                                    <JetResponsiveNavLink as="button">
                                        Log Out
                                    </JetResponsiveNavLink>
                                </form>

                                <!-- Team Management -->
                                <template v-if="$page.props.jetstream.hasTeamFeatures">
                                    <div class="border-t border-gray-200" />

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Team
                                    </div>

                                    <!-- Team Settings -->
                                    <JetResponsiveNavLink :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">
                                        Team Settings
                                    </JetResponsiveNavLink>

                                    <JetResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                        Create New Team
                                    </JetResponsiveNavLink>

                                    <div class="border-t border-gray-200" />

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <JetResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg
                                                        v-if="team.id == $page.props.user.current_team_id"
                                                        class="mr-2 h-5 w-5 text-green-400"
                                                        fill="none"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    ><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </JetResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Heading -->
                <header v-if="$slots.header" class="bg-grey-100 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main class="pt-12">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
