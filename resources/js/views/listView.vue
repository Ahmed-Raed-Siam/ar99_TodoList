<template>
    <div>
        List View
        <div v-for="(item,index) in items" :key="index">
            <list-item :item="item" class="item" v-on:itemChanged="$emit('reloadList')"></list-item>
        </div>
    </div>
</template>

<script>
import ListItem from "./listItem";

export default {
    name: "listView",
    components: {
        ListItem,
    },
    props: ['items'],
    data() {
        return {}
    },
}
</script>

<style scoped>
.item {
    background: #6fdda0;
    padding: 5px;
    margin-top: 5px;
}
</style>
