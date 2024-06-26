<div id="modalIncluirLoja" class="modal">
    <div class="modal-content">
        <form id="formIncluirLoja" action="{{ route('incluirLoja') }}" method="POST">
            @csrf
            <h4 class="center">Incluir</h4>
            <div class="input-field">
                <input id="lojnome" type="text" class="validate" name="lojnome" required>
                <label for="lojnome">Nome da Loja</label>
                @error('lojnome')
                    <span class="error-message" style="color:red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field">
                <input id="lojcnpj" type="number" class="validate" name="lojcnpj" required>
                <label for="lojcnpj">CNPJ</label>
                @error('lojcnpj')
                    <span class="error-message" style="color:red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field">
                <input id="lojtelefone" type="tel" class="validate" name="lojtelefone" placeholder="XX XXXXX-XXXX" required>
                <label for="lojtelefone">Telefone</label>
                @error('lojtelefone')
                    <span class="error-message" style="color:red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field">
                <input id="lojemail" type="email" class="validate" name="lojemail" required>
                <label for="lojemail">E-mail</label>
                @error('lojemail')
                    <span class="error-message" style="color:red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field">
                <input id="lojcep" type="number" class="validate" name="lojcep" placeholder="00000-000" required>
                <label for="lojcep">CEP</label>
                @error('lojcep')
                    <span class="error-message" style="color:red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field">
                <input id="lojrua_aux" type="text" class="validate" name="lojrua_aux">
                <input type="hidden" id="lojrua" name="lojrua" value="">
                <label for="lojrua">Rua</label>
                @error('lojrua')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field">
                <input id="lojbairro_aux" type="text" class="validate" name="lojbairro_aux">
                <input type="hidden" id="lojbairro" name="lojbairro" value="">
                <label for="lojbairro">Bairro</label>
                @error('lojbairro')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field">
                <input id="lojcidade_aux" type="text" class="validate" name="lojcidade_aux">
                <input type="hidden" id="lojcidade" name="lojcidade" value="">
                <label for="lojcidade">Cidade</label>
                @error('lojcidade')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field">
                <label for="lojestado">Estado</label>
                <br>
                <br>
                <input type="hidden" id="lojestado" name="lojestado" value="">
                <select name="lojestado_aux" class="validate browser-default" required>
                    <option value="" selected>Selecione...</option>
                    <!-- Lista de estados -->
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                </select>
                @error('lojestado')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field">
                <input id="lojnumeroendereco" type="number" class="validate" name="lojnumeroendereco" required>
                <label for="lojnumeroendereco">N° Endereço</label>
                @error('lojnumeroendereco')
                    <span class="error-message" style="color:red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field">
                <input id="lojcomplementoendereco" type="text" class="validate" name="lojcomplementoendereco">
                <label for="lojcomplementoendereco">Complemento Endereço</label>
                @error('lojcomplementoendereco')
                    <span class="error-message" style="color:red;">{{ $message }}</span>
                @enderror
            </div>
            <button id="btnEnviarFormIncluir" type="submit" class="btn waves-effect waves-light" style="background-color: orange">Salvar</button>
            <a href="#!" id="btnFecharIncluir" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#lojcep').on('blur', function() {
                var cep = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/obter-endereco-por-cep',
                    method: 'POST',
                    data: { cep: cep },
                    success: function (response) {
                        if (response.data.erro !== true) {
                            $('#lojrua_aux').val(response.data.logradouro).addClass('filled').prop('disabled', true);
                            $('#lojbairro_aux').val(response.data.bairro).addClass('filled').prop('disabled', true);
                            $('#lojcidade_aux').val(response.data.localidade).addClass('filled').prop('disabled', true);
                            $('select[name="lojestado_aux"]').val(response.data.uf).addClass('filled').prop('disabled', true);
                        
                            $('label[for="lojrua"]').addClass('active');
                            $('label[for="lojbairro"]').addClass('active');
                            $('label[for="lojcidade"]').addClass('active');

                        } else{
                            $('#lojrua_aux').val('').removeClass('filled').prop('disabled', false);
                            $('#lojbairro_aux').val('').removeClass('filled').prop('disabled', false);
                            $('#lojcidade_aux').val('').removeClass('filled').prop('disabled', false);
                            $('select[name="lojestado_aux"]').val('').removeClass('filled').prop('disabled', false);
                        
                            $('label[for="lojrua"]').addClass('active');
                            $('label[for="lojbairro"]').addClass('active');
                            $('label[for="lojcidade"]').addClass('active');
                        
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        // Lidar com erros aqui
                    }
                });
            });

            $('form').on('submit', function() {
                // Copie os valores dos campos auxiliares para os campos hidden
                $('#lojrua').val($('#lojrua_aux').val());
                $('#lojbairro').val($('#lojbairro_aux').val());
                $('#lojcidade').val($('#lojcidade_aux').val());
                $('#lojestado').val($('select[name="lojestado_aux"]').val());

                // Continue com o envio do formulário
                return true;
            });
        });
    </script>    