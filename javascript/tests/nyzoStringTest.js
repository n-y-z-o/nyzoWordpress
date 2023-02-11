class NyzoStringTest {

    constructor() {
    }

    run() {
        let result = [];

        result.push({ name: 'Test 1', result: 'test 1 was successful', successful: true });
        result.push({ name: 'Test 2', result: 'test 2 was successful', successful: true });
        result.push({ name: 'Test 3', result: 'test 3 was not successful', successful: false });

        return result;
    }
}