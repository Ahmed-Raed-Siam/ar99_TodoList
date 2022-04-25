<template>
    <div class="item">
        <input type="checkbox" @change="updateCheck()" v-model="item.completed" :checked="item.completed">
        <span :class="[item.completed ? 'completed' : '','itemText']">{{ item.name }}</span>
        <button @click="removeItem()" class="trashcan">
            <font-awesome-icon icon="trash"></font-awesome-icon>
        </button>
    </div>
</template>

<script>
export default {
    name: "listItem",
    props: ['item'],
    methods: {
        updateCheck() {
            // this.item.isChecked = !this.item.isChecked
            axios.put('api/item/' + this.item.id, this.item)
                .then(response => {
                    console.log('response status:' + response.status);
                    if (response.status === 200) {
                        this.$emit('itemChanged');
                    }
                }).catch(error => {
                console.log(error);
            });
        },
        removeItem() {
            axios.delete('api/item/' + this.item.id).then(response => {
                if (response.status === 200) {
                    this.$emit('itemChanged');
                }
            }).catch(error => {
                console.log(error);
            });
        }
    }
}
</script>

<style scoped>
.completed {
    text-decoration: line-through;
    color: #999999;
}

.itemText {
    width: 100%;
    padding: 20px;
}

.item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.trashcan {
    /*background: #e6e6e6;*/
    background: transparent;
    border: none;
    color: #ff0000;
    outline: none;
}
</style>
