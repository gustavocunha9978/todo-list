<template>
    <div class="input-group mb-4 shadow-sm">
      <input
        v-model="newTask"
        type="text"
        class="form-control rounded-start"
        placeholder="Add a new task..."
        @keyup.enter="addTask"
      />
      <button @click="addTask" class="btn btn-primary px-4">
        <i class="fas fa-plus"></i>
      </button>
    </div>
  </template>
  
  <script>
  export default {
    name: 'TaskInput',
    data() {
      return {
        newTask: '' 
      };
    },
    methods: {
      addTask() {
        if (this.newTask.trim() === '') return;
  
        
        this.$emit('add-task', this.newTask);
        this.newTask = ''; // Limpa 
      }
    }
  };
  </script>
  
  <style scoped>
  .input-group {
    width: 100%;
  }
  </style>
  