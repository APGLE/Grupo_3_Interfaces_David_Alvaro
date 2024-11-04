<template>
  <div>
    <h2>Crear Nuevo Evento</h2>
    <form @submit.prevent="submitEvent">
      <div>
        <label for="title">Título:</label>
        <input type="text" v-model="event.title" required />
      </div>
      <div>
        <label for="category">Categoría:</label>
        <select v-model="event.category" required>
          <option value="Música">Música</option>
          <option value="Deporte">Deporte</option>
          <option value="Tecnología">Tecnología</option>
        </select>
      </div>
      <div>
        <label for="date">Fecha:</label>
        <input type="date" v-model="event.date" required />
      </div>
      <div>
        <label for="description">Descripción:</label>
        <textarea v-model="event.description" required></textarea>
      </div>
      <div>
        <label for="image">Imagen:</label>
        <input type="file" @change="handleImageUpload" required />
      </div>
      <button type="submit">Crear Evento</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      event: {
        title: '',
        category: '',
        date: '',
        description: ''
      },
      image: null
    };
  },
  methods: {
    handleImageUpload(event) {
      this.image = event.target.files[0];
    },
    async submitEvent() {
      try {
        const formData = new FormData();
        formData.append('title', this.event.title);
        formData.append('category', this.event.category);
        formData.append('date', this.event.date);
        formData.append('description', this.event.description);
        formData.append('image', this.image);

        const response = await fetch('/events/create', {
          method: 'POST',
          body: formData
        });

        if (response.ok) {
          alert('Evento creado con éxito');
          this.resetForm();
        } else {
          alert('Error al crear el evento');
        }
      } catch (error) {
        console.error('Error al enviar el evento:', error);
        alert('Error al crear el evento');
      }
    },
    resetForm() {
      this.event = {
        title: '',
        category: '',
        date: '',
        description: ''
      };
      this.image = null;
    }
  }
};
</script>

<style scoped>
form {
  display: flex;
  flex-direction: column;
}
form > div {
  margin-bottom: 10px;
}
button {
  align-self: flex-start;
}
</style>
