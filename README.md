data-aggregator
---

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
| _label  | atendidas | abandonadas |
| ------- | --------- | ----------- |
| Grupo 1 | 60        | 6           |
| Grupo 2 | 90        | 9           |
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

$aggregator = new Aggregator(new AggregatorResultFactory(), PropertyAccess::createPropertyAccessor());

$definition = new Definition();
$definition->addRow(new RowDefinition('[grupo]', 'Grupo'));
$definition->addColumn(new ColumnDefinition('[atendidas]', new OperationSum()));
$definition->addColumn(new ColumnDefinition('[abandonadas]', new OperationSum()));

$aggregator->setDefinition($definition);

$result = $aggregator->aggregate($data);

print_r($result->getArrayResult());
```

# Exemplo 2 (Linhas virtuais utilizando filtros)

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
| _label         | contagem |
| -------------- | -------- |
| Dentro da meta | 3        |
| Fora da meta   | 2        |
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

$aggregator = new Aggregator(new AggregatorResultFactory(), PropertyAccess::createPropertyAccessor());

$definition = new Definition();

$filterIn = (new RowDefinitionFilter())->setRowColumnFilterRule('[tma]', new LessThanFilterRule(241));
$filterOut = (new RowDefinitionFilter())->setRowColumnFilterRule('[tma]', new GreaterThanFilterRule(240));

$definition->addRow((new RowDefinition('[virtual]', 'Dentro da meta'))->setRowDefinitionFilter($filterIn));
$definition->addRow((new RowDefinition('[virtual]', 'Fora da meta'))->setRowDefinitionFilter($filterOut));
$definition->addColumn(new ColumnDefinition('[contagem]', new OperationIncrement()));

$aggregator->setDefinition($definition);

$result = $aggregator->aggregate($data);

print_r($result->getArrayResult());
```