<template>
    <li class="list-group-item d-flex justify-content-between align-items-center py-3" 
        :class="{ 'bg-light': task.is_done }">
      <span 
        :class="{ 'text-decoration-line-through text-muted': task.is_done, 'fw-bold': !task.is_done }">
        {{ task.description }}
      </span>
  
      <div class="btn-group">
        <button @click="toggleTask" class="btn btn-success btn-sm me-1" v-if="!task.is_done">
          <i class="fas fa-check"></i>
        </button>
        <button @click="toggleTask" class="btn btn-secondary btn-sm me-1" v-else>
          <i class="fas fa-undo"></i>
        </button>
        <button @click="deleteTask" class="btn btn-danger btn-sm">
          <i class="fas fa-trash"></i>
        </button>
      </div>
    </li>
  </template>
  
  <script>
  export default {
    name: 'TaskItem',
    props: ['task'], // Recebe a tarefa do pai
    methods: {
      toggleTask() {
        this.$emit('toggle-task', this.task);
      },
      deleteTask() {
        this.$emit('delete-task', this.task.id);
      }
    }
  };
  </script>
  
  <style scoped>
  .list-group-item {
    transition: all 0.2s ease-in-out;
    font-size: 1.1rem;
  }
  .list-group-item:hover {
    transform: scale(1.01);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  </style>
  