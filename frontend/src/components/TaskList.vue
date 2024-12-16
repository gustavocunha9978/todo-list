<template>
  <div class="container mt-5">
    <!-- Título -->
    <h2 class="text-center mb-4 text-primary fw-bold">📝 To-do List</h2>

    <!-- Componente para entrada de nova tarefa -->
    <TaskInput @add-task="addTask" />

    <!-- Lista de Tarefas Ativas -->
    <h4 class="text-success mb-3">📋 Tarefas Ativas</h4>
    <ul class="list-group shadow-sm mb-4">
      <TaskItem 
        v-for="task in activeTasks" 
        :key="task.id" 
        :task="task" 
        @toggle-task="toggleTask" 
        @delete-task="deleteTask" 
      />
    </ul>

    <!-- Lista de Tarefas Concluídas -->
    <h4 class="text-secondary mb-3">✅ Concluído</h4>
    <ul class="list-group shadow-sm">
      <TaskItem 
        v-for="task in completedTasks" 
        :key="task.id" 
        :task="task" 
        @toggle-task="toggleTask" 
        @delete-task="deleteTask" 
      />
    </ul>
  </div>
</template>

<script>
import TaskInput from './TaskInput.vue';
import TaskItem from './TaskItem.vue';
import api from '../api';

export default {
  name: 'TaskList',
  components: { TaskInput, TaskItem },
  data() {
    return {
      tasks: []
    };
  },
  computed: {
    activeTasks() {
      return this.tasks.filter(task => !task.is_done);
    },
    completedTasks() {
      return this.tasks.filter(task => task.is_done);
    }
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await api.get('tasks');
        this.tasks = response.data;
      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    },
    async addTask(description) {
      try {
        await api.post('tasks', { description, is_done: false });
        this.fetchTasks();
      } catch (error) {
        console.error('Error adding task:', error);
      }
    },
    async toggleTask(task) {
      try {
        await api.put(`tasks/${task.id}`, { is_done: !task.is_done });
        this.fetchTasks();
      } catch (error) {
        console.error('Error toggling task:', error);
      }
    },
    async deleteTask(id) {
      try {
        await api.delete(`tasks/${id}`);
        this.fetchTasks();
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    }
  },
  mounted() {
    this.fetchTasks();
  }
};
</script>

<style scoped>
.container {
  max-width: 800px;
}
</style>
