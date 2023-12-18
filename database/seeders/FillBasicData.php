<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Estoque;
use App\Models\Fornecedor;
use App\Models\Localizacao;
use App\Models\Marca;
use App\Models\Produto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FillBasicData extends Seeder
{
    /**
     * Run the database seeds
     *
     * @return void
     */
    public function run()
    {
        $data =
            [
                'name' => 'Heryck',
                'email' => 'heryckmota@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('heryck1516'), // password

            ];
        User::create($data);


        $categoriasIniciais = [
            [
                'nome' => 'Cereais, pães e tubérculos',
                'descricao' => 'Nesse grupo que estão as fontes de carboidratos como aveia, pão, arroz, farinhas integrais, batata doce entre outros',
                'url_capa' => 'https://fotos.web.sapo.io/i/Be211c9ae/20652162_VavRw.jpeg'
            ],
            [
                'nome' => 'Hortaliças',
                'descricao' => 'Grupo das verduras e legumes, fontes de vitaminas, minerais e fibras',
                'url_capa' => 'https://www.rastrorural.com.br/media/k2/items/cache/4e0d2946bafc44e656cf2886c0b75bb2_L.jpg'
            ],
            [
                'nome' => 'Frutas',
                'descricao' => 'Fontes de fibras, vitaminas e minerais como maças, cerejas, morangos e etc',
                'url_capa' => 'https://s1.static.brasilescola.uol.com.br/be/conteudo/images/as-frutas-sao-alimentos-importantes-para-nossa-saude-alem-serem-muito-saborosas-5bdaec2def6bb.jpg'
            ],
            [
                'nome' => 'Leguminosas',
                'descricao' => 'Neste grupo estão os grãos como: feijões, lentilha, grão de bico, soja e oleaginosas',
                'url_capa' => 'https://content.paodeacucar.com/wp-content/uploads/2020/05/leguminosas-capa.jpg'
            ],
            [
                'nome' => 'Carnes e ovos',
                'descricao' => 'Este é o principal grupo das fontes de proteínas de origem animal',
                'url_capa' => 'https://www.gov.br/saude/pt-br/assuntos/noticias/2022/outubro/carnes-peixes-e-ovos-sao-ricos-em-proteinas-de-alta-qualidade/19.jpg/@@images/71d640a8-59fa-4cd2-b86a-0e83c83ef4cd.jpeg'
            ],
            [
                'nome' => 'Leite e derivados',
                'descricao' => 'Alimentos derivados do leite',
                'url_capa' => 'https://s2-ge.glbimg.com/s8N_cVygvZYvbGN55vP6cub2K_4=/0x0:724x483/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_bc8228b6673f488aa253bbcb03c80ec5/internal_photos/bs/2018/5/Y/2AZhoUSVOYCrMhyI5X9A/istock-910881428.jpg'
            ],
            [
                'nome' => 'Óleos e gorduras',
                'descricao' => '',
                'url_capa' => 'https://redeciadasaude.com.br/wp-content/uploads/2016/04/base-blog-site28.jpg'
            ],
            [
                'nome' => 'Açúcares',
                'descricao' => '',
                'url_capa' => 'https://alimentesebem.sesisp.org.br/app/uploads/2021/06/Acucares-729x410.png'
            ],
            [
                'nome' => 'Processados',
                'descricao' => '',
                'url_capa' => 'https://i0.wp.com/naturvida.com.br/wp-content/uploads/2021/05/alimento-processado-1.jpg?resize=1000%2C667&ssl=1'
            ],
        ];
        foreach ($categoriasIniciais as $categoria) {
            Categoria::create($categoria);
        }

        $fornecedores = [
            [
                "nome" => "Empresa A",
                "cnpj" => "12345678000190",
                "ativo" => true
            ],
            [
                "nome" => "Fornecedor XYZ",
                "cnpj" => "98765432000121",
                "ativo" => true
            ],
            [
                "nome" => "ABC Comércio Ltda",
                "cnpj" => "11222333000144",
                "ativo" => true
            ],
            [
                "nome" => "Empresa B",
                "cnpj" => "55444333000100",
                "ativo" => true
            ],
            [
                "nome" => "Fornecedor 123",
                "cnpj" => "77888999000166",
                "ativo" => true
            ],
            [
                "nome" => "Comércio LTDA",
                "cnpj" => "88777666000122",
                "ativo" => true
            ],
            [
                "nome" => "Empresa C",
                "cnpj" => "44555666000133",
                "ativo" => true
            ],
            [
                "nome" => "Fornecedor ABC",
                "cnpj" => "33222111000155",
                "ativo" => true
            ],
            [
                "nome" => "Comércio & Cia",
                "cnpj" => "66999888000177",
                "ativo" => true
            ],
            [
                "nome" => "Empresa D",
                "cnpj" => "99888777000144",
                "ativo" => true
            ],
        ];

        foreach ($fornecedores as $fornecedor) {
            Fornecedor::create($fornecedor);
        }

        $marcas_alimenticias = [
            ["nome" => "Nestlé"],
            ["nome" => "Coca-Cola"],
            ["nome" => "PepsiCo"],
            ["nome" => "Kellogg's"],
            ["nome" => "Mars, Incorporated"],
            ["nome" => "Mondelez International"],
            ["nome" => "General Mills"],
            ["nome" => "Danone"],
            ["nome" => "Unilever"],
            ["nome" => "Ferrero"],
        ];

        foreach ($marcas_alimenticias as $marca) {
            Marca::create($marca);
        }
        $produtosCadastrados = [];
        foreach (range(1, 9) as $numero) {
            $produto = [
                'nome' => 'Produto' . $numero,
                'codigo' => 'COD00' . $numero,
                'descricao' => 'Descrição do Produto ' . $numero,
                'data_validade' => Carbon::now(),
                'lote' => 'LT001',
                'unidade_medida' => 'kg',
                'fornecedor_id' => $numero,
                'data_entrada' => Carbon::now(),
                'preco' => 10.5,
                'marca_id' => $numero,
                'categoria_id' => $numero,
                'informacao_nutricional' => 'Informações nutricionais do Produto ' . $numero,
                'created_by' => 1
            ];
            
            $produtosCadastrados[] = Produto::create($produto);
        }
        foreach($produtosCadastrados as $produto){
            foreach(range(1,4) as $numero) {
                $estoque = Estoque::create([
                    'produto_id' => $produto->id,
                    'preco_venda' => $produto->preco,
                ]);

                $localizacao = Localizacao::create([
                    'categoria_id' => $produto->categoria_id,
                    'prateleira' => $produto->categoria_id ,
                    'posicao'=> $numero,
                    'estoque_id'=> $estoque->id
                ]);
            }
        }
    }
}
