<!-- File: resources/js/views/socios/List.vue -->
<template>
  <div class="app-container">
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
  },
};
</script>