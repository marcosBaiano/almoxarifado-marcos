import { state } from './state.js';
import { refreshDashboard, renderAuditoria, renderProdutosSelects, renderProdutosTable } from './ui.js';

export class AuditoriaService {
    static log(evento, anterior, novo) {
        const logItem = {
            id: state.auditoria.length + 1,
            timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
            usuario: 'Manuel Silva',
            evento,
            dados_anteriores: typeof anterior === 'object' ? JSON.stringify(anterior) : anterior,
            dados_novos: typeof novo === 'object' ? JSON.stringify(novo) : novo,
            ip: '192.168.10.45'
        };

        state.auditoria.unshift(logItem);
        renderAuditoria();
    }
}

export class EstoqueService {
    static registrarMovimentacao(produtoId, tipo, quantidade, documentoRef, destino, operador = 'Manuel Silva') {
        const produto = state.produtos.find(p => p.id === produtoId);
        if (!produto) {
            throw new Error('Artigo nao localizado no banco de dados.');
        }

        const saldoAnterior = produto.estoque_atual;
        let saldoPosterior = saldoAnterior;

        if (tipo === 'ENTRADA') {
            saldoPosterior += quantidade;
        } else if (tipo === 'SAIDA') {
            if (saldoAnterior < quantidade) {
                throw new Error(`Rotina transacional abortada: Stock insuficiente de ${produto.descricao_resumida}.`);
            }
            saldoPosterior -= quantidade;
        } else if (tipo === 'AJUSTE') {
            saldoPosterior = quantidade;
        }

        const copiaSeguraAnterior = { ...produto };
        produto.estoque_atual = saldoPosterior;

        const mov = {
            id: state.movimentacoes.length + 1,
            produto_id: produtoId,
            timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
            tipo,
            quantidade,
            saldo_anterior: saldoAnterior,
            saldo_posterior: saldoPosterior,
            documento_ref: documentoRef,
            operador,
            destino
        };

        state.movimentacoes.unshift(mov);
        AuditoriaService.log(`MOV_ESTOQUE_${tipo}`, copiaSeguraAnterior, produto);

        refreshDashboard();
        renderProdutosTable();
        renderProdutosSelects();

        return true;
    }
}
