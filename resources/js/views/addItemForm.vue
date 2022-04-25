<template>
    <div class="addItem">
        <input type="text" v-model="item.name"/>
        <font-awesome-icon icon="plus-square" @click="addItem()"
                           :class="[ item.name ? 'active' : 'inactive' , 'plus']"/>
    </div>
</template>

<script>
export default {
    name: "addItemForm",
    data() {
        return {
            item: {
                name: ""
            }
        }
    },
    methods: {
        addItem() {
            if (this.item.name === '') {
                return;
            }
            axios.post('/api/item', {
                name: this.item.name
            }).then(response => {
                if (response.status === 201) {
                    this.item.name = '';
                    this.$emit('reloadList')
                    // console.log(response);
                    // console.log(response.data.data);
                    // console.log('Created:',response.data.data.item);
                    // console.log('response.status :', response.status);
                }
            }).catch(error => {
                console.log(error);
            });
        },
    },
}
</script>

<style scoped>
.addItem {
    display: flex;
    justify-content: center;
    align-items: center;
}

input {
    background: white;
    border: 0;
    outline: none;
    padding: 5px;
    margin-right: 10px;
    width: 100%;
}

.plus {
    font-size: 20px;
}

.active {
    color: #00ce25;
}

.inactive {
    color: #999999;
}

</style>
