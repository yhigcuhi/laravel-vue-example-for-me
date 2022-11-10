<!-- 共通 ヘッダー -->
<script>
    export default {
        mounted() {
            console.log('Header Component mounted.')
        }
    }
</script>

<!-- 共通 ヘッダー テンプレート -->
<template>
    <div class="container-fluid bg-dark mb-3">
        <div class="container">
            <nav class="navbar navbar-dark">
                <span class="navbar-brand mb-0 h1">
                    <router-link v-bind:to="{name: 'home'}">
                        Example Vue Laravel SPA
                    </router-link>
                </span>
                <div class="px-4">
                    <router-link v-bind:to="{name: 'task.list'}" class="mx-3">
                        <button class="btn btn-success">List</button>
                    </router-link>
                    <router-link v-bind:to="{name: 'task.new'}" class="mx-3" exact>
                        <button class="btn btn-success">ADD</button>
                    </router-link>
                </div>
            </nav>
        </div>
    </div>
</template>
