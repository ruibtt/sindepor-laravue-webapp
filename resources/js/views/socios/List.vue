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
      <!-- Coluna com o botão Eliminar -->
      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEditForm(scope.row.id, scope.row.nome)"
          >
            Editar
          </el-button>
          <el-button
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.nome)"
          >
            Eliminar
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- Elemento do dialog -->
    <el-dialog :title="formTitle" :visible.sync="socioFormVisible">
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
      formTitle: '',
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
      this.formTitle = 'Nova ficha de Sócio';
      this.socioFormVisible = true;
      this.currentSocio = {
        nome: '',
        num_socio: '',
        regiao: '',
        local_trabalho: '',
      };
    },
    // Ativa o Dialog para a edição do registo
    handleEditForm(id) {
      this.formTitle = 'Edição da ficha do Sócio';
      this.currentSocio = this.list.find((socio) => socio.id === id);
      this.socioFormVisible = true;
    },
    // Trata da Submissão dos dados
    handleSubmit() {
      // Se o ID estiver indefinido, então cria novo registo
      // Senão, atualiza o registo
      if (this.currentSocio.id !== undefined) {
        socioResource
          .update(this.currentSocio.id, this.currentSocio)
          .then((response) => {
            this.$message({
              type: 'success',
              message: 'Ficha do Sócio foi atualizada com sucesso!',
              duration: 5 * 1000,
            });
            this.getList();
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.socioFormVisible = false;
          });
      } else {
        socioResource
          .store(this.currentSocio)
          .then((response) => {
            this.$message({
              message:
                'Novo Sócio ' +
                this.currentSocio.name +
                ' foi criado com sucesso!',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentSocio = {
              nome: '',
              num_socio: '',
              regiao: '',
              local_trabalho: '',
            };
            this.socioFormVisible = false;
            this.getList();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    // Trata da Eliminação
    handleDelete(id, name) {
      this.$confirm(
        'Esta ação elimina o registo do Sócio ' + name + '. Continuar?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          socioResource
            .destroy(id)
            .then((response) => {
              this.$message({
                type: 'success',
                message: 'Registo eliminado com sucesso!',
              });
              this.getList();
            })
            .catch((error) => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Eliminação cancelada!',
          });
        });
    },
  },
};
</script>
