data-aggregator [![Open Source Love](https://badges.frapsoft.com/os/v2/open-source.svg?v=103)](https://github.com/ellerbrock/open-source-badge/) [![Build Status](https://api.travis-ci.org/brunohanai/data-aggregator.svg?branch=master)](https://travis-ci.org/brunohanai/data-aggregator) [![Coverage Status](https://coveralls.io/repos/github/brunohanai/data-aggregator/badge.svg?branch=master)](https://coveralls.io/github/brunohanai/data-aggregator?branch=master)     
---

O objetivo do `data-aggregator` é agrupar as informações de um array (futuramente objetos também) realizando
operações como Soma, Contagem e cálculos definidos manualmente.

# Exemplo 1

**Transformar isso:**

```
$data = array(
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 1', 'atendidas' => 10, 'abandonadas' => 1, 'tma' => 230),
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 2', 'atendidas' => 20, 'abandonadas' => 2, 'tma' => 235),
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 3', 'atendidas' => 30, 'abandonadas' => 3, 'tma' => 240),
    array('grupo' => 'Grupo 2', 'fila' => 'Fila 4', 'atendidas' => 40, 'abandonadas' => 4, 'tma' => 245),
    array('grupo' => 'Grupo 2', 'fila' => 'Fila 5', 'atendidas' => 50, 'abandonadas' => 5, 'tma' => 250),
);
```

**Em isso:**

```
$data = array(
    array('_label' => 'Grupo 1', 'atendidas' => 60, 'abandonadas' => 6),
    array('_label' => 'Grupo 2', 'atendidas' => 90, 'abandonadas' => 9),
);
```

**Código:**

```php
$data = array(
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 1', 'atendidas' => 10, 'abandonadas' => 1, 'tma' => 230),
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 2', 'atendidas' => 20, 'abandonadas' => 2, 'tma' => 235),
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 3', 'atendidas' => 30, 'abandonadas' => 3, 'tma' => 240),
    array('grupo' => 'Grupo 2', 'fila' => 'Fila 4', 'atendidas' => 40, 'abandonadas' => 4, 'tma' => 245),
    array('grupo' => 'Grupo 2', 'fila' => 'Fila 5', 'atendidas' => 50, 'abandonadas' => 5, 'tma' => 250),
);

$definition = new Definition();
$definition->addRow(new RowDefinition('[grupo]', 'Grupo'));
$definition->addColumn(new ColumnDefinition('[atendidas]', new OperationSum()));
$definition->addColumn(new ColumnDefinition('[abandonadas]', new OperationSum()));

$aggregator = DataAggregator::createAggregator();
$aggregator->setDefinition($definition);

$result = $aggregator->aggregate($data);

print_r($result->getArrayResult());
```

# Exemplo 2 (Linhas virtuais utilizando filtros)

**Transformar isso:**

```
$data = array(
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 1', 'atendidas' => 10, 'abandonadas' => 0, 'tma' => 230),
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 2', 'atendidas' => 15, 'abandonadas' => 0, 'tma' => 235),
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 3', 'atendidas' => 5, 'abandonadas' => 0, 'tma' => 240),
    array('grupo' => 'Grupo 2', 'fila' => 'Fila 4', 'atendidas' => 50, 'abandonadas' => 40, 'tma' => 245),
    array('grupo' => 'Grupo 2', 'fila' => 'Fila 5', 'atendidas' => 20, 'abandonadas' => 10, 'tma' => 250),
);
```
**Em isso:**

```
$data = array(
    array('_label' => 'Todos',          'contagem' => 5, 'atendidas' => 100, 'abandonadas' => 50, 'atendidas-porcentagem' => 66.66),
    array('_label' => 'Dentro da meta', 'contagem' => 3, 'atendidas' => 30,  'abandonadas' => 0,  'atendidas-porcentagem' => 100),
    array('_label' => 'Fora da meta',   'contagem' => 2, 'atendidas' => 70,  'abandonadas' => 50, 'atendidas-porcentagem' => 58.33),
);
```

**Código:**

```php
$data = array(
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 1', 'atendidas' => 10, 'abandonadas' => 0, 'tma' => 230),
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 2', 'atendidas' => 15, 'abandonadas' => 0, 'tma' => 235),
    array('grupo' => 'Grupo 1', 'fila' => 'Fila 3', 'atendidas' => 5, 'abandonadas' => 0, 'tma' => 240),
    array('grupo' => 'Grupo 2', 'fila' => 'Fila 4', 'atendidas' => 50, 'abandonadas' => 40, 'tma' => 245),
    array('grupo' => 'Grupo 2', 'fila' => 'Fila 5', 'atendidas' => 20, 'abandonadas' => 10, 'tma' => 250),
);

$definition = new Definition();

$filterIn = (new RowDefinitionFilter(new AffirmativeStrategy()))
    ->setRowColumnFilter('[tma]', new Filter(new LessThanFilterRule(241)));
$filterOut = (new RowDefinitionFilter(new AffirmativeStrategy()))
    ->setRowColumnFilter('[tma]', new Filter(new GreaterThanFilterRule(240)));

$g = (new FilterGroup(new UnanimousStrategy()))
    ->addFilter(new Filter(new LessThanFilterRule(300)))
    ->addFilter(new Filter(new GreaterThanFilterRule(200)));
$filterAll = (new RowDefinitionFilter(new AffirmativeStrategy()))->setRowColumnFilter('[tma]', $g);

$definition->addRow((new RowDefinition('[virtual]', 'Todos'))->setRowDefinitionFilter($filterAll));
$definition->addRow((new RowDefinition('[virtual]', 'TMA Dentro da meta'))->setRowDefinitionFilter($filterIn));
$definition->addRow((new RowDefinition('[virtual]', 'TMA Fora da meta'))->setRowDefinitionFilter($filterOut));
$definition->addColumn(new ColumnDefinition('[contagem]', new OperationIncrement()));
$definition->addColumn(new ColumnDefinition('[atendidas]', new OperationSum()));
$definition->addColumn(new ColumnDefinition('[abandonadas]', new OperationSum()));
$definition->addColumn(new ColumnDefinition('[atendidas_porcentagem]', new OperationManualCalc('[atendidas] / ([atendidas] + [abandonadas]) * 100')));

$aggregator = DataAggregator::createAggregator();
$aggregator->setDefinition($definition);

$result = $aggregator->aggregate($data);

print_r($result->getArrayResult());
```