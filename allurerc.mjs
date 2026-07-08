export default {
  name: "Allure PHP API",
  output: "./out/allure-report",
  plugins: {
    testops: {
      options: {
        launchName: `Allure PHP API GitHub actions run (${new Date().toISOString()})`,
      },
    },
  },
};
