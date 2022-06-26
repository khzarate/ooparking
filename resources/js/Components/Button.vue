<template>
  <button
    :type="type"
    :class="customClass(bgColor, txtCase, round)"
    class="
      inline-flex
      items-center
      px-4
      py-2
      border border-transparent
      font-semibold
      text-xs text-white
      tracking-widest
      transition
      ease-in-out
      duration-150
    "
  >
    <slot />
  </button>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: "submit",
    },
    bgColor: {
      bgColor: String,
      default:
        "bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray",
    },
    txtCase: {
      txtCase: String,
      default: "normal",
    },
    round: {
      round: String,
      default: "rounded-none",
    },
  },
  methods: {
    customClass: function (bgColor, txtCase, round) {
      return (
        this.backgroundColorClass(bgColor) +
        " " +
        this.textCaseClass(txtCase) +
        " " +
        this.roundClass(round)
      );
    },
    backgroundColorClass: function (bgColor) {
      switch (bgColor) {
        case "blue":
          return "bg-blue-500 hover:bg-blue-400 active:bg-blue-600 focus:outline-none focus:border-blue-600 focus:shadow-outline-blue";
        case "dark-green":
          return "bg-green-700 hover:bg-green-400 active:bg-green-600 focus:outline-none focus:border-green-600 focus:shadow-outline-green";
        case "green":
          return "bg-green-500 hover:bg-green-400 active:bg-green-600 focus:outline-none focus:border-green-600 focus:shadow-outline-green";
        case "yellow":
          return "bg-yellow-500 hover:bg-yellow-400 active:bg-yellow-600 focus:outline-none focus:border-yellow-600 focus:shadow-outline-yellow";
        case "red":
          return "bg-red-500 hover:bg-red-400 active:bg-red-600 focus:outline-none focus:border-red-600 focus:shadow-outline-red";
        case "light-red":
          return "bg-red-400 hover:bg-red-400 active:bg-red-600 focus:outline-none focus:border-red-600 focus:shadow-outline-red";
        default:
          return "bg-gray-500 hover:bg-gray-400 active:bg-gray-600 focus:outline-none focus:border-gray-600 focus:shadow-outline-gray";
      }
    },
    textCaseClass: function (txtCase) {
      switch (txtCase) {
        case "uppercase":
          return "uppercase";
        case "lowercase":
          return "lowercase";
        default:
          return "normal";
      }
    },
    roundClass: function (round) {
      switch (round) {
        case "full":
          return "rounded-full";
        case "lg":
          return "rounded-lg";
        case "md":
          return "rounded-md";
        case "sm":
          return "rounded-sm";
        case "none":
          return "rounded-none";
        default:
          return "rounded";
      }
    },
  },
};
</script>