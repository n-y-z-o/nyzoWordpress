function runNyzoTests(targetDiv) {
    // Remove existing children from the target div.
    while (targetDiv.firstChild) {
        targetDiv.removeChild(targetDiv.firstChild);
    }

    // Add the table.
    const table = document.createElement('div');
    table.className = 'table';
    targetDiv.appendChild(table);

    // Add the header.
    const headerRow = document.createElement('div');
    headerRow.className = 'header-row';
    table.appendChild(headerRow);
    for (let label of [ 'test name', 'result' ]) {
        const labelDiv = document.createElement('div');
        labelDiv.textContent = label;
        headerRow.appendChild(labelDiv);
    }

    const tests = [
        new NyzoStringTest
    ];

    // Run the tests.
    let successful = true;
    for (let test of tests) {
        // Add the result row to the table.
        const resultRow = document.createElement('div');
        resultRow.className = 'data-row';
        table.appendChild(resultRow);

        // Add the test name to the result row.
        const nameDiv = document.createElement('div');
        nameDiv.textContent = test.constructor.name;
        resultRow.appendChild(nameDiv);

        // Add the test result to the result row.
        const resultDiv = document.createElement('div');
        resultDiv.textContent = '-';
        resultRow.appendChild(resultDiv);
    }
}