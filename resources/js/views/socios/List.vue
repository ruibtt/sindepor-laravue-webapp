<!-- File: resources/js/views/socios/List.vue -->
<template>
  <div class="app-container">
    <!-- Botão para criar novo registo -->
    <div class="filter-container">
      <el-button
        class="filter-item"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
      >
        {{ $t('table.add') }}
      </el-button>
    </div>
    <!-- Elemento da Tabela -->
    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Nome" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.nome }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Num. Sócio" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.num_socio }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Região">
        <template slot-scope="scope">
          <span>{{ scope.row.regiao }}</span>
        </template>
      </el-table-column>
    </el-table>
    <!-- Elemento do dialog -->
    <el-dialog :title="'Ficha de Sócio'" :visible.sync="socioFormVisible">
      <div class="form-container">
        <el-form
          ref="categoryForm"
          :model="currentSocio"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentSocio.nome" />
          </el-form-item>
          <el-form-item label="Num. Sócio" prop="num_socio">
            <el-input v-model="currentSocio.num_socio" type="textarea" />
          </el-form-item>
          <el-form-item label="Região" prop="regiao">
            <el-input v-model="currentSocio.regiao" type="textarea" />
          </el-form-item>
          <el-form-item label="Local de Trabalho" prop="local_trabalho">
            <el-input v-model="currentSocio.local_trabalho" type="textarea" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="socioFormVisible = false"> Cancel </el-button>
          <el-button type="primary" @click="handleSubmit()">
            Confirm
          </el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
const socioResource = new Resource('socios');

export default {
  name: 'SocioList',
  data() {
    return {
      list: [],
      loading: true,
      socioFormVisible: false,
      currentSocio: {},
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await socioResource.list({});
      this.list = data;
      this.loading = false;
    },
    handleCreate() {
      this.socioFormVisible = true;
      this.currentSocio = {
        nome: '',
        num_socio: '',
        regiao: '',
        local_trabalho: '',
      };
    },
    // File: resources/js/views/categories/List.vue
    handleSubmit() {
      socioResource
        .store(this.currentSocio)
        .then((response) => {
          this.$message({
            message:
              'Novo Sócio ' +
              this.currentSocio.nome +
              ' foi criado com sucesso!',
            type: 'success',
            duration: 5 * 1000,
          });
          this.currentSocio = {
            name: '',
            description: '',
          };
          this.socioFormVisible = false;
          this.getList();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
